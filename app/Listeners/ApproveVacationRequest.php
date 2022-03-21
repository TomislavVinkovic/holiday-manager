<?php

namespace App\Listeners;

use App\Events\VacationRequestApprovalApprovedEvent;
use Illuminate\Support\Carbon;
use App\Events\ApprovalEmailEvent;

class ApproveVacationRequest
{
    
    public function __construct() {
        
    }
    
    public function handle(VacationRequestApprovalApprovedEvent $event){
        //if the lead approves the request...
        if($event->approved) {
            $event->approval->approved = true;
            $event->approval->pending = false;
            
            //if there are no requests left to approve
            if($event->vacationRequest->approvals->where('approved', false)->isEmpty()) {
                $event->vacationRequest->approved = true;
                Carbon::setHolidaysRegion('hr');
                $start_date = Carbon::create($event->vacationRequest->start_date);
                $end_date = Carbon::create($event->vacationRequest->end_date);
                $diff = $start_date->diffInDaysFiltered(function (Carbon $date) {
                    return !$date->isWeekend() && !$date->isHoliday(); //oduzmi mu dane odmora ne brojeci vikende
                }, $end_date);

                $event->vacationRequest->user->available_vacation_days -= $diff;

                $event->approval->save();
                $event->vacationRequest->push();
                ApprovalEmailEvent::dispatch($event->vacationRequest);
                return;
            }
            $event->approval->save();
            $event->vacationRequest->push();
        }
        //else, if the lead declined the request
        else {
            $event->approval->approved = false;
            $event->approval->pending = false;
            $event->approval->save();

            $event->vacationRequest->approved = false;
            $event->vacationRequest->save();

            ApprovalEmailEvent::dispatch($event->vacationRequest);
        }
    }
}
