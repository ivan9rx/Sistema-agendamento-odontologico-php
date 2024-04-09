<?php

namespace App\Models;



use App\Entities\Service;
use CodeIgniter\Exceptions\PageNotFoundException;


class ServiceModel extends MyBaseModel
{
    protected $table            = 'services';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Service::class;
    protected $useSoftDeletes   = false; // o registro sera excluido
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
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
        'nome'        => 'required|is_unique[services.nome,id,{id}]',
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
    protected $beforeInsert   = ['escapeData'];
    protected $beforeUpdate   = ['escapeData'];



}
