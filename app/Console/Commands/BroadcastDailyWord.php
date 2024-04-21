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
        $word = \App\Models\Word::inRandomOrder()->first();

        \Spatie\SlackAlerts\Facades\SlackAlert::blocks([
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
                    'text' => $word->word.' heeft een reting van '.$word->rating.($word->author ? ' en werd bedacht door viezerik '.$word->author->name : '').'.',
                ],
            ],
            [
                'type' => 'divider',
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'plain_text',
                    'text' => $word->text,
                ]
            ]
        ]);
    }
}
