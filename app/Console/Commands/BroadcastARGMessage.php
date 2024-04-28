<?php

namespace App\Console\Commands;

use App\Models\Reply;
use App\Slack\Facades\Replier;
use Illuminate\Console\Command;

class BroadcastARGMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast-arg-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcasts a ARG message to the slack channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $silent = (bool) config('settings.silent');
        $level = (int) config('settings.level');

        if ($silent) {
            return;
        }

        if ($level < 2) {
            return;
        }

        $client = \JoliCode\Slack\ClientFactory::create(config('app.slack_bot_token'));

        $client->chatPostMessage([
            'channel' => config('app.slack_channel_id'),
            'as_user' => true,
            'text' => Replier::reply(Reply::TYPE_ARG),
        ]);
    }
}
