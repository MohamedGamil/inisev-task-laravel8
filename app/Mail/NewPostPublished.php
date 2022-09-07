<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostPublished extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $websiteName;
    protected $title;
    protected $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $websiteName, $title, $description)
    {
        $this->email = $email;
        $this->websiteName = $websiteName;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'email' => $this->email,
            'websiteName' => $this->websiteName,
            'title' => $this->title,
            'description' => $this->description,
        ];

        return $this->view('mail.new_post_published', $data)
            ->subject("New post has been published by {$this->websiteName}")
            ->to($this->email);
    }
}
