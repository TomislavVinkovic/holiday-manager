<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(protected bool $approved){}

    public function build()
    {
        return $this->from('holidaymanagerteam@example.org', 'Holiday Manager Team')
                    ->subject($this->approved ? 'Vacation request approved': 'Vacation request denied')
                    ->markdown('mails.vacationApproval')
                    ->with([
                        'approved' => $this->approved
                    ]);
    }
}
