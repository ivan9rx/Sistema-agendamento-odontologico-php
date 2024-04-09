<?php

namespace App\Validation;

class Schedule
{
    public function rules(): array
    {
        return [
            'dentista_id' => [
                'rules'     => 'is_natural_no_zero|is_not_unique[dentistas.id]',
                'errors'    => [
                    'is_natural_no_zero'  => 'Dentista inválido',
                    'is_not_unique'       => 'Dentista inválido'
                ],
            ],

            'service_id' => [
                'rules'     => 'is_natural_no_zero|is_not_unique[services.id]',
                'errors'    => [
                    'is_natural_no_zero'  => 'Dado errado',
                    'is_not_unique'       => 'Serviço inválido'
                ],
            ],

            'month' => [
                'rules'     => 'required|max_length[2]',
                'errors'    => [
                    'required'            => 'Informe o mês',
                    'max_length[2]'       => 'Mês no formato invalido'
                ],
            ],
            'day' => [
                'rules'     => 'required|max_length[2]',
                'errors'    => [
                    'required'            => 'Informe o dia',
                    'max_length[2]'       => 'Dia no formato invalido'
                ],
            ],
            'hour' => [
                'rules'     => 'required|exact_length[5]',
                'errors'    => [
                    'required'            => 'Informe a hora',
                    'exact_length[5]'       => 'Hora no formato invalido'
                ],
            ],
        ];
    }
}
