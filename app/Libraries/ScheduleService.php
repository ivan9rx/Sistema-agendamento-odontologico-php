<?php

namespace App\libraries;

use App\Entities\Schedule;
use App\Models\DentistaModel;
use App\Models\ScheduleModel;
use App\Models\ServiceModel;
use CodeIgniter\Events\Events;
use CodeIgniter\I18n\Time;
use Exception;
use InvalidArgumentException;

class ScheduleService
{


    /**
     * renderiza a lista com  as opções de serviços disponíveis para associação através de checkbox
     * @return string
     */
    public function renderDentistas(): string
    {

        //dentistas ativos e com serviços associados

        $where = [
            'active' => 1,
            'servicos !=' => ''
        ];

        $dentistas = model(DentistaModel::class)->where($where)->orderBy('nome', 'ASC')->findAll();

        if (empty($dentistas)) {


            return '<div class="text-info mt-5" >Não há dentistas para agendamento disponíveis</div>';
        }

        //valor padrão
        $radios = '';

        foreach ($dentistas as $dentista) {

            $radios .= '<div class="form-check mb-2">';
            $radios .= "<input type='radio' name='dentista_id' data-dentista='{$dentista->nome} \nEndereço: {$dentista->endereco}' value='{$dentista->id}' class='form-check-input' id='radio-dentista-{$dentista->id}'>";
            $radios .= "<label class='form-check-label' for='radio-dentista-{$dentista->id}'>{$dentista->nome}<br>{$dentista->endereco}</label>";
            $radios .= '</div>';
        }


        // retorna a lista de opções
        return $radios;
    }

    /**
     * recupera os serviços associados ao profissional informado como um dropdownHTML
     * @param integer
     * @return string
     */

    public function renderDentistasServices(int $dentistaId): string
    {
        //validamos a existência do profissional ativo com serviços
        $dentista = model(DentistaModel::class)->where(['active' => 1, 'servicos !=' => null, 'servicos !=' => ''])->findOrFail($dentistaId);

        $services = model(ServiceModel::class)->whereIn('id', $dentista->servicos)->where('active', 1)->orderBy('nome', 'ASC')->findAll();

        if (empty($services)) {
            throw new InvalidArgumentException("Os serviços associados ao profissional {$dentista->nome} não estão ativos ou não existem");
        }

        $options = [];
        $options[null] = '---Escolha---';

        foreach ($services as $service) {
            $options[$service->id] = $service->nome;
        }

        return form_dropdown(data: 'service', options: $options, selected: [], extra: ['id' => 'service_id', 'class' => 'form-select']);
    }

    // tentar criar o agendamento do user logado
    public function createSchedule(array $request): bool|string
    {
        try {

            $model = model(ScheduleModel::class);

            $request = (object) $request;

            $dentista = model(DentistaModel::class)->where(['id' => $request->dentista_id])->findOrFail($request->dentista_id);




            $currentYear = Time::now()->getYear();

            //terei algo assim 2023-09-01 15:30
            $chosenDate = "{$currentYear}-{$request->month}-{$request->day} {$request->hour}";

            if (!$model->chosenDateIsFree(dentistaId: $request->dentista_id, chosenDate: $chosenDate)) {

                return "A data escolhida não está mais disponível";
            };

            $schedule = new Schedule([
                'dentista_id' => $request->dentista_id,
                'service_id'  => $request->service_id,
                'chosen_date' => $chosenDate
            ]);

            //conseguimos criar o agendamento?

            if (!$createdId = $model->insert($schedule)) {

                log_message('error', 'Erro ao criar agendamento', $model->errors());

                return "Não foi possível criar o agendamento";
            }

            /**
             * disparamos email para o user logado
             */

            Events::trigger('schedule_created', $dentista->email, $model->getSchedule(id: $createdId));

            Events::trigger('schedule_created', auth()->user()->email, $model->getSchedule(id: $createdId));

            return true;
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);
            return "Internal Server Error";
        }
    }
}
