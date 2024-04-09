<?php 

namespace App\Notifications;

use App\Entities\Schedule;
use CodeIgniter\Email\Email;
use CodeIgniter\I18n\Time;
use Config\Services;

class CanceledScheduleNotification
{

    /** @var Email */
    protected Email $service;

    /** @var string */
    protected string $email;


    /** @var Schedule */
    protected Schedule $schedule;

    public function __construct(string $email, Schedule $schedule)
    {
        $this->service = Services::email();
        $this->email = $email;

        $this->schedule = $schedule;
    }

    public function send(): bool
    {
        $this->service->setTo($this->email);
        $this->service->setSubject('Seu agendamento foi cancelado');

        $data = [
            'chosen_date' => $this->schedule->chosen_date,
            'dentista'    => $this->schedule->dentista,
            'service'    => $this->schedule->service,
            'endereco'    => $this->schedule->endereco,
            'when'        => Time::now()->format('d/m/Y H:i'),  
        ];

        $this->service->setMessage(view('Front/Email/schedule_canceled', $data));
        $this->service->setMailType('html');

        if(! $this->service->send()){
            log_message('error', $this->service->printDebugger());

            return false;
        }

        return true;
    }


}