<?php

namespace App\Mail;

use App\License;
use App\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Events\CustomerRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerSubscribe extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $event;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( CustomerRegisteredEvent $event )
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.new-customer');
    }
}
