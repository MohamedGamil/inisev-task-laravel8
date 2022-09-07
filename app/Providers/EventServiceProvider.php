<?php

namespace App\Providers;

use App\Events\EmailSent;
use App\Events\PostPublished;
use App\Listeners\MarkMailAsDelivered;
use App\Listeners\SendMailWhenPostPublished;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PostPublished::class => [
            SendMailWhenPostPublished::class,
        ],
        EmailSent::class => [
            MarkMailAsDelivered::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
