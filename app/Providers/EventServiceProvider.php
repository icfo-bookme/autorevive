<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ShipmentAssigned;
use App\Events\ShipmentCompleted;
use App\Listeners\ShipmentAssignedNotification;
use App\Listeners\ShipmentCompletedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        ShipmentAssigned::class => [
            ShipmentAssignedNotification::class,
        ],

        ShipmentCompleted::class => [
            ShipmentCompletedListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
