<?php

namespace App\Jobs;

use App\Events\EmailSent;
use App\Models\Website;
use App\Models\Post;
use App\Mail\NewPostPublished;
use App\Models\SubscriptionDelivery;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Published website instance.
     *
     * @var \App\Models\Website
     */
    protected $website;

    /**
     * Published post instance.
     *
     * @var \App\Models\Post
     */
    protected $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Website $website, Post $post)
    {
        $this->website = $website;
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $postId = $this->post->id;
        $title = $this->post->title;
        $desc = $this->post->description;
        $websiteName = $this->website->name;
        $subs = $this->website->subscriptions;

        foreach ($subs as $sub) {
            $email = $sub->email;
            $subId = $sub->id;

            \Log::debug("Attempting to send email Post ID: ({$postId}) - Sub ID: ({$subId}).");

            if (true === SubscriptionDelivery::checkDelivery($postId, $subId)) {
                \Log::debug("Mail delivery skipped for Post ID: ({$postId}) - Sub ID: ({$subId}).");
                continue;
            }

            $mailer->send(new NewPostPublished($email, $websiteName, $title, $desc));

            event(new EmailSent($this->post, $sub));
        }

        \Log::debug("Mail job success.");
    }
}
