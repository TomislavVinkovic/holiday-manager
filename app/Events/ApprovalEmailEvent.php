<?php

namespace App\Events;

use App\Models\VacationRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApprovalEmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public VacationRequest $vacationRequest){}


    public function broadcastOn()
    {
        return new PrivateChannel('approval-email-channel');
    }
}
