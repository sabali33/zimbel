<?php

namespace App\Mail;

use App\License;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerHasSubscribed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $license;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(License $license)
    {
        $this->license = $license;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.subscription');
    }
}
