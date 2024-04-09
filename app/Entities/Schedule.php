<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Schedule extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'finished' => 'boolean',
        'canceled' => 'boolean',
    ];

    public function updatedAt(): string {

        return Time::parse($this->updated_at)->format('d-m-Y H:i');
    }

    public function situation(): string {
        $updatedFormated = $this->updatedAt();

        if($this->finished) {
            return "Finalizado em {$this->updatedAt()}";
        }

        if($this->canceled) {
            return "Cancelado em {$this->updatedAt()}";
        }

        $isBefore = Time::parse($this->chosen_date)->isBefore(Time::now());

        return $isBefore ? "Ocorreu em {$this->formated_chosen_date}" : "Será em {$this->formated_chosen_date}";

    }

    public function canBeCanceled(): bool {
        if($this->finished || $this->canceled) {
            return false;
        }
        
        return Time::parse($this->chosen_date)->isAfter(Time::now());
    }
}
