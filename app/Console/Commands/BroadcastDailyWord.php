<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BroadcastDailyWord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast-daily-word';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcasts a daily word to the slack channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $silent = (bool) config('settings.silent');

        if ($silent) {
            return;
        }

        $word = \App\Models\Word::inRandomOrder()->first();
        $blocks = [
            [
                'type' => 'section',
                'text' => [
                    'type' => 'plain_text',
                    'text' => \App\Slack\Facades\Replier::reply(\App\Models\Reply::TYPE_WOTD),
                ]
            ],
            [
                'type' => 'header',
                'text' => [
                    'type' => 'plain_text',
                    'text' => $word->word.'!!!',
                ]
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'plain_text',
                    'text' => 'Dit prachtige woord heeft een reting van '.$word->rating.($word->author ? ' en werd bedacht door taalvirtuoos '.$word->author->name : '').'.',
                ],
            ],
            [
                'type' => 'divider',
            ],
        ];

        if ($word->text) {
            $blocks[] = [
                'type' => 'section',
                'text' => [
                    'type' => 'plain_text',
                    'text' => $word->text,
                ],
            ];
        }

        $client = \JoliCode\Slack\ClientFactory::create(config('app.slack_bot_token'));

        $client->chatPostMessage([
            'channel' => config('app.slack_channel_id'),
            'as_user' => true,
            'blocks' => json_encode($blocks),
        ]);
    }
}
