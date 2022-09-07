<?php

namespace App\Events;

use App\Models\Post;
use App\Models\Subscription;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Mockery\Matcher\Subset;

class EmailSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Published post instance.
     *
     * @var \App\Models\Subscription
     */
    protected $subscription;

    /**
     * Published post instance.
     *
     * @var \App\Models\Post
     */
    protected $post;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post, Subscription $subscription)
    {
        $this->post = $post;
        $this->subscription = $subscription;
    }

    /**
     * Get Post ID
     */
    public function getPostId()
    {
        return $this->post->id ?? -1;
    }

    /**
     * Get Subscription ID
     */
    public function getSubscriptionId()
    {
        return $this->subscription->id ?? -1;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
