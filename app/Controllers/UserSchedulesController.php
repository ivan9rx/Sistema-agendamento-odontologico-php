<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserScheduleService;
use CodeIgniter\Config\Factories;
use CodeIgniter\HTTP\ResponseInterface;

class UserSchedulesController extends BaseController
{

    private UserScheduleService $userScheduleService;

    public function __construct()
    {
        $this->userScheduleService = Factories::class(UserScheduleService::class);
    }

    public function index()
    {
        $data = [
            'title' => 'Meus agendamentos',
        ];

        return view('Front/Schedules/user_schedules', $data);
    }



    public function all()
    {



        try {
            $this->checkMethod('ajax');

            $schedules = $this->userScheduleService->all();

            return $this->response->setJSON([
                'schedules' => $schedules
            ]);
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);
            $this->response->setStatusCode(500);
        }
    }


    public function cancel()
    {



        try {
            $this->checkMethod('ajax');

            $request = (object) $this->request->getJSON();

            $this->userScheduleService->cancelUserSchedule((int) $request->schedule);

            return $this->response->setJSON([
                'success' => true,
                'token'    => csrf_hash(),
            ]);
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);
            $this->response->setStatusCode(500);
        }
    }
}
