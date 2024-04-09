<?php

namespace App\Libraries;

use App\Models\ScheduleModel;
use CodeIgniter\Events\Events;
use Exception;

class UserScheduleService
{

    private ScheduleModel $scheduleModel;

    public function __construct()
    {
        $this->scheduleModel = model(ScheduleModel::class);
    }


    public function all(): string
    {



        $schedules = $this->scheduleModel->getLoggedUserSchedules();

        if (empty($schedules)) {

            $anchor = '<div class="alert alert-info mb-4">Você ainda não tem agendamentos</div>';
            $anchor .= anchor(route_to('schedules.new'), 'Criar agendamentos', ['class' => 'btn btn-primary']);

            return $anchor;
        }

        $ul = '<ul class="list-group">';

        foreach ($schedules as $schedule) {

            $ul .= '<li class="list-group-item d-flex justify-content-between align-items-start">';

            $btnCancel = '';

            if ($schedule->canBeCanceled()) {
                $btnCancel .= $this->renderBtnCancel($schedule->id);
            }

            $ul .= "<div class='ms-2 me-auto'>
                        <div class='fw-bold'>{$schedule->dentista} {$schedule->endereco}</div>
                        {$schedule->service}
                        <p>{$btnCancel}</p>
                   </div>";

            $ul .= $schedule->situation();

            $ul .= '</li>';
        }


        $ul .= '</ul>';



        return $ul;
    }

    private function renderBtnCancel(int|string $id): string
    {
        return form_button([
            'class' => 'btn btn-danger btn-sm mt-4 btnCancelSchedule',
            'data-schedule' => $id
        ], 'Cancelar');
    }

    //processa o cancelamento do agendamento do user logado
    public function cancelUserSchedule(int|string $id): bool
    {

        try {

            $where = [
                'id'     => $id,
                'user_id' => auth()->user()->id,
                'canceled' => 0, // que ainda não foi cancelado
            ];

            $success = $this->scheduleModel->where($where)->set('canceled', 1)->update();

            if(! $success) {
                throw new Exception("Não foi possível cancelar o agendamento {$id} do usuário");
            }

            $schedule = $this->scheduleModel->where('user_id', auth()->user()->id)->getSchedule($id);

            Events::trigger('schedule_canceled',auth()->user()->email, $schedule);



            return true;
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            return false;
        }
    }
}
