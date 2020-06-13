<?php

namespace App\Providers;

use App\Events\ModelCreatedEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Events\CustomerRegisteredEvent;
use App\Listeners\SendNewCustomerEmail;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ModelCreatedEvent::class => [
            App\Listeners\UploadMediaListener::class,
            App\Listeners\AttachMetaListener::class,
        ],
        CustomerRegisteredEvent::class => [
            SendNewCustomerEmail::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
