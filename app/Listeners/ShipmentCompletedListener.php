<?php

namespace App\Listeners;

use App\Events\ShipmentCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShipmentCompletedListener
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
     * @param  shipmentCompleted  $event
     * @return void
     */
    public function handle(ShipmentCompleted $event)
    {
        //

        return $event;
    }
}
