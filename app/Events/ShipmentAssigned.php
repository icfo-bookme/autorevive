<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ShipmentAssigned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $redirect_link;
    public $notification_by;
    public $notification_to;

    /**
     * Create a new event instance. 
     * 
     * @edited_by Usama
     * @edit_list
     *          added - commented out the previous __construct() and added a new one
     *
     * @return void
     */

    public function __construct($message, $redirect_link, $notification_by, $notification_to)
    {
        $this->message = $message;
        $this->redirect_link = $redirect_link;
        $this->notification_by = $notification_by;
        $this->notification_to = $notification_to;

        // persist
        \DB::table('shipment_notifications')->insert([
            'message' => $this->message,
            'redirect_link' => $this->redirect_link,
            'is_seen' => 0,
            'notification_by' => $this->notification_by,
            'notification_to' => $this->notification_to,
            'soft_delete' => 0
        ]);
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('testChannel');
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}


/**
 *     Previous __construct()
 * 
 *     // public function __construct($message)
 *     // {
 *     //     //
 *     //     $this->message = $message;
 *     // }
*/