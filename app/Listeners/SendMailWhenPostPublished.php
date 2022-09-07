<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Jobs\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Bus\Dispatcher;

class SendMailWhenPostPublished implements ShouldQueue
{
    protected $dispatcher;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PostPublished $event)
    {
        $post = $event->getPost();
        $website = $event->getWebsite();

        \Log::debug("Dispatching mail job.");

        $this->dispatcher->dispatch(new SendMail($website, $post));
    }
}
