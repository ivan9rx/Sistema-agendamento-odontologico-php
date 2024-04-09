<?php

namespace App\Libraries;

use App\Models\DentistaModel;
use App\Models\ScheduleModel;
use CodeIgniter\I18n\Time;
use DateInterval;
use DatePeriod;

class DentistaAvaiableHoursService
{


    /**
     * renderiza as horas disponíveis para serem escolhidas no agendamento
     * @param array
     * @param string|null
     */
    public function renderHours(array $request): string|null
    {
        try {

            $request = (object)$request;

            //precisamos obter a unidade mês e dia desejados
            $dentistaId = (string) $request->dentista_id;
            $month = (string) $request->month;
            $day = (string) $request->day;

            //adicionamos um zero a esquerda do  mês e dia, quando for o caso

            $month = strlen($month) < 2 ? sprintf("$02d", $month) : $month;
            $day = strlen($day) < 2 ? sprintf("$02d", $day) : $day;

            //validamos a existência do profissional
            $dentista = model(DentistaModel::class)->where(['active'=>1, 'servicos !=' =>null, 'servicos !='=> ''])->findOrFail($dentistaId);


            //data atual
            $now = Time::now();

            //obtemos a data desejada
            //teremos algo assim: 2024-03-28
            $dateWanted = "{$now->getYear()}-{$month}-{$day}";

            /**
             * @todo quando estivermos criando agendamentos, precisamos buscar os agendamentos já realizados para a unidade em questão
             * precisamos verificar se a data desejada é a data atual
             */

            $isCurrentDay = $dateWanted === $now->format('Y-m-d');

            $timeRange = $this->createDentistaTimeRange(
                start: $dentista->starttime,
                end: $dentista->endtime,
                interval: $dentista->servicetime,
                isCurrentDay: $isCurrentDay
            );


          
            //Abertura da div com horários com valor padrão null
            $divHours = null;

            

             foreach($timeRange as $hour){
                /**
                 * verificar  se o horário ja não existe na tabela de agendamentos
                 */

                 $divHours .= form_button(data:['class' => 'btn btn-hour btn-primary', 'data-hour' => $hour], content:$hour);
            }

            //retornamos o range de horários

            return $divHours;

        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            return "Não foi possível recuperar os horaríos disponiveis";
        }
    }

    /**
     * cria um array com range de horários de acordo com inicio fim e intervalo
     * @param string $start
     * @param string $end
     * @param string $interval
     * @param boolean $isCurrentDay
     * 
     * 
     */
    private function createDentistaTimeRange(string $start, string $end, string $interval, bool $isCurrentDay): array
    {
        $period = new DatePeriod(
            new Time($start),
            DateInterval::createFromDateString($interval),
            new Time($end)
        );

        //receberá os tempos gerados
        $timeRange = [];

        //tempo atual em hora e minutos para comparar com a hora e minutos gerados no for each abaixo
        $now = Time::now()->format('H:i');

        foreach ($period as $instance) {

            //recuperamos o tempo no formato 'hh:mm'

            $hour = Time::createFromInstance($instance)->format('H:i');

            //se não for o dia atual fazemos o push normal

            if (!$isCurrentDay) {

                $timeRange[] = $hour;
            } else {
                //aqui dentro é o dia atual
                //verificamos se a hora de inicio é maior que a hora atual
                //dessa forma só apresentamos horários que forem maior que a hora atual
                //ou  seja, não apresentamos horas passadas

                if ($hour > $now) {
                    $timeRange[] = $hour;
                }
            }
        }

        //finalmente retornamos os horários gerados
        return $timeRange;
    }
}
