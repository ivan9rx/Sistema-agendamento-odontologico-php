<?php

namespace App\libraries;

use App\Entities\Dentista;
use App\Models\DentistaModel;
use App\Models\ScheduleModel;
use CodeIgniter\Config\Factories;

class DentistaService extends MyBaseService
{


    private static array $serviceTimes = [
        '10 minutes' => '10 minutos',
        '15 minutes' => '15 minutos',
        '30 minutes' => '30 minutos',
        '1 hour' => 'Uma hora',
        '2 hour' => 'Duas horas',
    ];



    public function renderDentistas(): string
    {
        $dentistas = model(DentistaModel::class)->orderby('nome', 'ASC')->findAll();

        if (empty($dentistas)) {
            return self::TEXT_FOR_NO_DATA;
        }

        $this->htmlTable->setHeading('Ações', 'nome', 'E-mail', 'telefone', 'Seviços', 'Situação', 'criado');

        $dentistaServiceService = Factories::class(DentistaServiceService::class);

        foreach ($dentistas as $dentista) {

            $this->htmlTable->addRow(
                [
                    $this->renderBtnActions($dentista),
                    $dentista->nome,
                    $dentista->email,
                    $dentista->phone,
                    $dentistaServiceService->renderDentistaServices($dentista->servicos),
                    $dentista->status(),
                    $dentista->createdAt(),
                ]
            );
        }

        return $this->htmlTable->generate();
    }


    /**
     * renderiza um dropdown HTML com  as opçoes de tempo necessarios para cada atendimento
     * @param string/null $serviceTime intervalo ja associado ao registro, quando for o cas0
     * @return string
     * 
     */
    public function renderTimesInterval(?string $serviceTime = null): string
    {

        $options = [];
        $options[''] = '--- Escolha ---';

        foreach (self::$serviceTimes as $key => $time) {
            $options[$key] =  $time;
        }

        return form_dropdown(data: 'servicetime', options: $options, selected: old('servicetime', $serviceTime), extra: ['class' => 'form-control']);
    }

    //renderiza uma lista não ordenada html dos agendamentos do dentista
    public function renderDentistaSchedules(int|string $dentistaId): string
    {
        $schedules = model(ScheduleModel::class)->getDentistaSchedules($dentistaId);

        if (empty($schedules)) {
            return self::TEXT_FOR_NO_DATA;
        }

        $list = [];

        foreach ($schedules as $schedule) {
            $list[] = "<p>
                            <strong>Dentista:</strong> {$schedule->dentista} <br>
                            <strong>Endereço:</strong> {$schedule->endereco} <br>
                            <strong>Serviço:</strong> {$schedule->servico} <br>
                            <strong>Situação:</strong> {$schedule->situation()} <br>
                            <strong>Nome do cliente:</strong> {$schedule->user} <br>
            
                       </p>";
        }

        return ul($list);
    }


    /**
     *  renderiza o dropdown
     * 
     * @param Dentista $dentista
     * @return string
     * 
     * 
     */

    private function renderBtnActions(Dentista $dentista): string
    {

        $btnActions = '<div class="btn-group dropup">';
        $btnActions .= '<button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>';
        $btnActions .= '<div class="dropdown-menu">';
        $btnActions .= anchor(route_to('dentistas.edit', $dentista->id), 'Editar', ['class' => 'dropdown-item']);
        $btnActions .= anchor(route_to('dentistas.services', $dentista->id), 'Serviços', ['class' => 'dropdown-item']);
        $btnActions .= anchor(route_to('dentistas.schedules', $dentista->id), 'Agendamentos', ['class' => 'dropdown-item']);
        $btnActions .= view_cell(
            library: 'ButtonsCell::action',
            params: [
                'route'        => route_to('dentistas.action', $dentista->id),
                'text_action'  => $dentista->textToAction(),
                'activated'    => $dentista->isActivated(),
                'btn_class'    => 'dropdown-item py-2'
            ]
        );
        $btnActions .= view_cell(
            library: 'ButtonsCell::destroy',
            params: [
                'route'        => route_to('dentistas.destroy', $dentista->id),
                'btn_class'    => 'dropdown-item py-2'
            ]
        );
        $btnActions .= '</div> </div>';

        return $btnActions;
    }
}
