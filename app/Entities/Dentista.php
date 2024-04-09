<?php

namespace App\Entities;

class Dentista extends MyBaseEntity
{

    protected $casts = [
        'servicos'  => '?json-array',
    ];


}
