<?php

namespace App\Events;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostPublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Published post instance.
     *
     * @var \App\Models\Post
     */
    protected $post;

    /**
     * Published post instance.
     *
     * @var \App\Models\Website
     */
    protected $website;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Website $website, Post $post)
    {
        $this->website = $website;
        $this->post = $post;
    }

    /**
     * Get Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Get Website
     */
    public function getWebsite()
    {
        return $this->website;
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
