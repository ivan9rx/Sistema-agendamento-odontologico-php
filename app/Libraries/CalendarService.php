<?php

namespace App\libraries;

use CodeIgniter\I18n\Time;
use InvalidArgumentException;

class CalendarService
{

    /**
     * @var array meses
     */
    private static array $months = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];

    /**
     * rederiza um dropdown dos meses a serem escolhidos no agendamento
     * @return string
     */
    public function renderMonths(): string
    {


        $today = Time::now();
        $currentYear = $today->getYear();
        $currentMonth = $today->getMonth();


        $options = [];
        $options[null] = '---Escolha---';

        //Mês atual é maior que key
        foreach (self::$months as $key => $month) {
            if ($currentMonth > $key) {

                //Então continuamos para o próximo item do array
                //pois não queremos exibir meses passados 
                continue;
            }
            $options[$key] = "{$month} / {$currentYear}";
        }

        return form_dropdown(data: 'month', options: $options, selected: [], extra: ['id' => 'month', 'class' => 'form-select']);
    }


    /**
     * @param integer
     * @return string
     * @throws Exception
     */
    public function generate(int $month): string
    {
        try {
            //tempo atual
            $now = Time::now();

            $currentMonth = (int) $now->getMonth();

            $year = (int) $now->getYear();

            if ($month < $currentMonth || !in_array($month, array_keys(self::$months))) {
                throw new InvalidArgumentException("O mês {$month} não é um mês valido para gerar o calendario");
            };

            //objeto para termos acesso ao primeiro dia da semana do primeiro dia do mês
            $firstDayObject = $now::create(year: $year, month: $month, day: 1);

            //obitem a quantidade de dias do mês 
            $daysOfMonth = $firstDayObject->format('t');

            //obtém a representação númerica do dia da semena 0(domingo)  até 6(sabádo)
            $startDay = (int) $firstDayObject->format('w');

            //abertura da div que comporta o calendário
            $calendar = '<div class="table-responsive">';

            //abertura da tabela
            $calendar .= '<table class="table table-sm table-borderless">';

            //dias da semana
            $calendar .= '<tr class="text-center">
                         <td>Dom</td>
                         <td>Seg</td>
                         <td>Ter</td>
                         <td>Qua</td>
                         <td>Qui</td>
                         <td>Sex</td>
                         <td>Sab</td>
                        <tr/>
            ';
            //enquanto o dia de inicio for maior que zero, adiciono as células vazias através do for, até que encontremos o dia incial da semena

            if ($startDay > 0) {

                for ($i = 0; $i < $startDay; $i++) {
                    $calendar .= '<td>&nbsp</td>';
                }
            }

            //nesse ponto podemos popular o calendario
            for ($day = 1; $day <= $daysOfMonth; $day++) {
                /**
                 * @todo redenrizar botão com o dia
                 */

                $btnDay = $this->renderDayButton(day: $day, month: $month, isWeekend: $this->isWeekend(year: $year, month: $month, day: $day));

                $calendar .= "<td>{$btnDay}</td>";

                //vamos incrementar o dia de inicio
                $startDay++;

                //se o startDay for igual a sete, adicionamos uma nova linha na tabela

                if ($startDay == 7) {
                    //reinicio o start day em 0
                    $startDay = 0;

                    //se o dia corrente for menor do que o daysOfMonth, então realizamos a abertura de uma 

                    if ($day < $daysOfMonth) {

                        $calendar .= '<tr>';
                    }
                }
            }

            if ($startDay > 0) {
                for ($i = $startDay; $i < 7; $i++) {
                    $calendar .= '<td>&nbsp</td>';
                }

                $calendar .= '</tr>';
            }

            //fechamos a tabela
            $calendar .= '</table>';

            //fechamos o div table-responive 
            $calendar .= '</div>';

            //finalmente retornamos o calendario com os dias para o mês desejado

            return $calendar;
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);
            return "Não foi possível gerar um calendario para o mês informado";
        }
    }

    /**
     * verifica se a data informada é em um final de semana
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @return boolean
     * 
     */
    private function isWeekend(int $year, int $month, int $day): bool
    {
        //vamos obter o primeiro dia do mês informado no formato unix e timestomp
        $timeCreated = Time::create(year: $year, month: $month, day: $day);
        $dayOfWeeak = (int) $timeCreated->format('w');

        //0 = > domingo
        //6 => sabádo
        return ($dayOfWeeak === 0 || $dayOfWeeak === 6);
    }


    /**
     * renderiza botão html para click no front
     * @param integer $day
     * @param integer $month
     * @param boolean $isWeekend
     * @return string
     */
    private function renderDayButton(int $day, int $month, bool $isWeekend = false): string
    {

        //atributos padrão para o botão
        $attributes = [
            'type' => 'button',
            'class' => 'btn btn-primary btn-calendar-day'
        ];

        //data atual

        $now = Time::now();

        $currentDay = (int) $now->getDay();
        $currentMonth = (int) $now->getMonth();

        //se o dia for menor que o dia atual e o mês for igual ao dia corrente
        //então desabilitamos o botão

        if ($day < $currentDay && $month === $currentMonth || $isWeekend) {
            $attributes['disabled'] = true;
        } else {
            $attributes['class'] = "chosenDay {$attributes['class']}";//usados no front
            $attributes['data-day'] = $day; //usados no front
        }
        return form_button(data: $attributes, content: "{$day}");
    }
}
