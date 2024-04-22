<?php

namespace App\Console\Commands;

use App\Models\Reply;
use App\Slack\Facades\Replier;
use Illuminate\Console\Command;

class BroadcastFridayMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast-friday-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcasts a friday message to the slack channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $silent = (bool) config('settings.silent');

        if ($silent) {
            return;
        }

        $client = \JoliCode\Slack\ClientFactory::create(config('app.slack_bot_token'));

        $client->chatPostMessage([
            'channel' => config('app.slack_channel_id'),
            'as_user' => true,
            'text' => Replier::reply(Reply::TYPE_FRIDAY),
        ]);
    }
}
