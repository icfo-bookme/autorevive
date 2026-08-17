<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StockCountSheet extends Mailable
{
    use Queueable, SerializesModels;
    public $stockCountSheet;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($stockCountSheet)
    {
            $this->stockCountSheet     = $stockCountSheet;
            $this->subject  = 'Physical stock count backup';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject($this->subject)->view('mail.stockCountSheet');
    }
}
