<?php

namespace App\Controllers;

use App\Models\DentistaModel;
use App\Libraries\DentistaService;
use CodeIgniter\Config\Factories;

class HomeController extends BaseController
{


    
    public function index(): string
    {
        $data = [
            'title' => 'Home',
            'user' => 'ivan'
        ];
       return view('Front/Home/index', $data);
    }



   
}
