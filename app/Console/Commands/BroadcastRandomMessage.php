<?php

namespace App\Console\Commands;

use App\Models\Reply;
use App\Slack\Facades\Replier;
use Illuminate\Console\Command;

class BroadcastRandomMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast-random-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcasts a random message to the slack channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Spatie\SlackAlerts\Facades\SlackAlert::message(Replier::reply(Reply::TYPE_RANDOM));
    }
}
