<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BroadcastMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcasts a message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = \JoliCode\Slack\ClientFactory::create(config('app.slack_bot_token'));

        $client->chatPostMessage([
            'channel' => config('app.slack_channel_id'),
            'as_user' => true,
            'text' => 'Dankje lieve jongeman',
        ]);
    }
}
