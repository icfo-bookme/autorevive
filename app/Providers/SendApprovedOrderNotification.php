<?php

namespace App\Providers;

use App\Providers\ApprovedOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendApprovedOrderNotification
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
     * @param  ApprovedOrder  $event
     * @return void
     */
    public function handle(ApprovedOrder $event)
    {
        //
    }
}
