<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PosSaleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $subject;
    public $email;
    public $number;
    public $address;
    public $orderCode;
    public $orderInfo;
    public $orderDetailsInfo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstName,$lastName,$email,$number,$address, $orderCode, $orderInfo, $orderDetailsInfo)
    {
        $this->subject   = 'Thank You';
        $this->name      = $firstName.' '. $lastName;
        $this->email     = $email;
        $this->number    = $number;
        $this->address   = $address;
        $this->orderCode = $orderCode;
        $this->orderInfo = $orderInfo;
        $this->orderDetailsInfo  = $orderDetailsInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $this->subject($this->subject)->view('mail.posSale');
    }
}
