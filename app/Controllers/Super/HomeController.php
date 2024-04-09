<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\libraries\DentistaService;
use App\Models\DentistaModel;
use CodeIgniter\Config\Factories;
use App\Models\ScheduleModel;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    
    /** @var DentistaService */
    private DentistaService $dentistaService;

    /** @var DentistaModel */
    private DentistaModel $dentistaModel;

    /** constructor */
    public function __construct()
    {
        $this->dentistaService = Factories::class(DentistaService::class);
        $this->dentistaModel = model(DentistaModel::class);
    }


    public function index()
    {
        $data = [
            'title' => 'Home',
        ];
        return view('Back/Home/index', $data);
    }

    

   
}
