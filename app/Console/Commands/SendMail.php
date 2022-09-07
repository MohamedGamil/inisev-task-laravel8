<?php

namespace App\Console\Commands;

use App\Models\Website;
use App\Jobs\SendMail as SendMailJob;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Console\Command;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all pending subscription email messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Dispatcher $dispatcher)
    {
        $websites = Website::all();

        foreach($websites as $website) {
            $posts = $website->posts;

            foreach($posts as $post) {
                $dispatcher->dispatch(new SendMailJob($website, $post));
            }
        }

        $this->info('Subscription email messages jobs dispatched.');
    }
}
