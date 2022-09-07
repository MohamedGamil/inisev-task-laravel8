<?php

namespace App\Listeners;

use App\Events\EmailSent;
use App\Models\SubscriptionDelivery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkMailAsDelivered implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EmailSent $event)
    {
        $postId = $event->getPostId();
        $subId = $event->getSubscriptionId();

        SubscriptionDelivery::setDelivered($postId, $subId);

        \Log::debug("Mail delivered.");
    }
}
