<?php

namespace App\Listeners;

use App\Events\ApprovalEmailEvent;
use App\Mail\VacationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmailToEmployee implements ShouldQueue
{

    public function construct() {

    }
    
    public function handle(ApprovalEmailEvent $event) {
        Mail::to($event->vacationRequest->user->email)->send(new VacationMail($event->vacationRequest->approved));
    }
}
