<?php

namespace App\Listeners;

use App\Mail\CustomerHasSubscribed;
use Illuminate\Support\Facades\Mail;
use App\Events\CustomerRegisteredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewCustomerEmail
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle( CustomerRegisteredEvent $event )
    {
        //$event->customer->user->email
        Mail::to($event->customer->user->email)->send(new CustomerHasSubscribed( $event->license ));
    }
}
