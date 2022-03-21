<?php

namespace App\Events;

use App\Models\VacationRequestApproval;
use App\Models\VacationRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class VacationRequestApprovalApprovedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    
    public function __construct(
        public VacationRequestApproval $approval,
        public VacationRequest $vacationRequest,
        public bool $approved
        ) {
            
        }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('approval-channel');
    }
}
