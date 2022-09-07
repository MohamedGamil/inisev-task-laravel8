<?php

namespace App\Console\Commands;

use App\Models\Website;
use Illuminate\Console\Command;

class CreateWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new website';

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
    public function handle()
    {
        $name = $this->ask('Enter new website name:');
        $slug = $this->ask('Enter new website slug:');
        $desc = $this->ask('Enter new website description:');
        $ownerId = $this->ask('Enter owner ID:');

        $website = new Website([
            'name' => $name,
            'slug' => $slug,
            'owner_id' => $ownerId,
        ]);

        if (false === $website->save()) {
            $this->warn('Unable to create a new website using given attributes!');
        }

        $this->info('Website created successfully.');
    }
}
