<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\ApproveVacationRequest;
use App\Listeners\SendVerificationEmailToEmployee;
use App\Events\ApprovalEmailEvent;
use App\Events\VacationRequestApprovalApprovedEvent;

class EventServiceProvider extends ServiceProvider
{
    
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        VacationRequestApprovalApprovedEvent::class => [
            ApproveVacationRequest::class,
        ],
        ApprovalEmailEvent::class => [
            SendVerificationEmailToEmployee::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
