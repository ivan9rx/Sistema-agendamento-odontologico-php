<?php

namespace App\Models;

use App\Entities\Schedule;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;

class ScheduleModel extends MyBaseModel
{
    protected $table            = 'schedules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Schedule::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'dentista_id',
        'service_id',
        'user_id',
        'finished',
        'canceled',
        'chosen_date',
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];


    protected $validationMessages   = [];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData', 'setUserId'];
    protected $beforeUpdate   = ['escapeData'];

    //define no array de dados o id do usuario logado
    protected function setUserId(array $data): array 
    {
        //o usuario está logado??
        if(!auth()->loggedIn()) {

            throw new Exception('Não existe uma sessão válida');
        }

        if(!isset($data['data'])) {
            return $data;
        }

        $data['data']['user_id'] = auth()->user()->id;

        return $data;

    }

    public function chosenDateIsFree(int|string $dentistaId, string $chosenDate): bool 
    {
        return $this->where('dentista_id', $dentistaId)->where('chosen_date', $chosenDate)->first() === null;
    }

    // recupera o agendamento de acordo com o id
    public function getSchedule(int|string $id): Schedule
    {

        $this->select([
            'schedules.*',
            'dentistas.nome AS dentista',
            'dentistas.endereco',
            'services.nome AS service',
        ]);

        $this->join('dentistas', 'dentistas.id = schedules.dentista_id');
        $this->join('services', 'services.id = schedules.service_id');

        return $this->findOrFail($id);
    }


    public function getLoggedUserSchedules(): array
     {

        if(!auth()->loggedIn()) {
            return [];
        }

        $this->select([
            'schedules.*',
            'schedules.chosen_date AS formated_chosen_date',
            'dentistas.nome AS dentista',
            'dentistas.endereco',
            'services.nome AS servico'
        ]);

        $this->join('dentistas', 'dentistas.id = schedules.dentista_id');
        $this->join('services', 'services.id = schedules.service_id');
        $this->where('schedules.user_id', auth()->user()->id);
        $this->orderBy('schedules.id', 'DESC');

        return $this->findAll();
    }


    public function getDentistaSchedules(int|string $dentistaId): array
    {


       $this->select([
           'schedules.*',
           'schedules.chosen_date AS formated_chosen_date',
           'dentistas.nome AS dentista',
           'dentistas.endereco',
           'services.nome AS servico',
           'users.username AS user',
       ]);

       $this->join('dentistas', 'dentistas.id = schedules.dentista_id');
       $this->join('services', 'services.id = schedules.service_id');
       $this->join('users', 'users.id = schedules.user_id');
       $this->where('schedules.dentista_id', $dentistaId);
       $this->orderBy('schedules.id', 'DESC');

       return $this->findAll();
   }



    
}
