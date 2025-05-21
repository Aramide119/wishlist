<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawFundEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $withdrawal;
    public $user;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($withdrawal, $user)
    {
        $this->withdrawal = $withdrawal;
        $this->user = $user;

  
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.emails.withdraw-funds');
    }
}
