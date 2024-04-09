<?php

namespace App\Models;


use  App\Entities\Dentista;


class DentistaModel extends MyBaseModel
{
    protected $table            = 'dentistas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Dentista::class;
    protected $useSoftDeletes   = false; // o registro sera excluido
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
        'email',    
        'phone',
        'endereco',
        'servicos',
        'starttime',
        'endtime' ,
        'servicetime',
        'active',
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'id'          => 'permit_empty|is_natural_no_zero',
        'nome'        => 'required',
        'phone'       => 'required|is_unique[dentistas.phone,id,{id}]',
        'email'       => 'required|valid_email|is_unique[dentistas.email,id,{id}]',
        'endereco'    => 'required',
        'starttime'   => 'required',
        'endtime'    => 'required',
        'servicetime' => 'required',
    ];


    protected $validationMessages   = [
        'nome' => [
            'required'=> 'Obrigatório',
            'is_unique'=> 'Já existe',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeCustomData'];
    protected $beforeUpdate   = ['escapeCustomData'];

    protected function escapeCustomData(array $data): array 
    {
        if(!isset($data['data'])) {
            return $data;
        }

        foreach($this->allowedFields as $attibute){

            if(isset($data['data'][$attibute])){
                if($attibute === 'servicos') {
                    continue;
                }
                $data['data'][$attibute] = esc($data['data'][$attibute]);
            }

        }

        return $data;

    }

}
