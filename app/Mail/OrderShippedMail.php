<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShippedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $orderInfo;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderInfo)
    {
        $this->subject   = 'Order Shipped';
        $this->orderInfo = $orderInfo;
       
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $this->subject($this->subject)->view('mail.orderShipped');
    }
}
