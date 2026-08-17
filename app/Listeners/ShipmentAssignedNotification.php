<?php

namespace App\Listeners;

use App\Events\ShipmentAssigned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShipmentAssignedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ShipmentAssigned  $event
     * @return void
     */
    public function handle(ShipmentAssigned $event)
    {
        //

      
        return $event;
    }
}
