<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $subject;
    public $email;
    public $number;
    public $address;
    public $orderCode;





    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstName,$lastName,$email,$number,$address,$orderCode)
    {
        $this->name      = $firstName.' '. $lastName;
        $this->subject   = 'Order Received';
        $this->email     = $email;
        $this->number    = $number;
        $this->address   = $address;
        $this->orderCode = $orderCode;



    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $this->subject($this->subject)->view('mail.orderReceived');
    }
}
