<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderApproved extends Mailable
{
    use Queueable, SerializesModels;
    public $orderInfo;
    public $orderDetailsInfo;
    public $shippingCharge;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderInfo,$orderDetailsInfo,$shippingCharge)
    {
            $this->orderInfo         = $orderInfo;
            $this->orderDetailsInfo  = $orderDetailsInfo;
            $this->shippingCharge    = $shippingCharge;
            $this->subject           = 'Order Approved';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject($this->subject)->view('mail.orderApproved');
    }
}
