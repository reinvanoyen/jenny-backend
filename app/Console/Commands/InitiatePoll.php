<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitiatePoll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initiate-poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcasts a randomly generated poll';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $silent = (bool) config('settings.silent');

        if ($silent) {
            return;
        }

        $words = \App\Models\Word::inRandomOrder()->limit(5)->get();

        $options = [];

        foreach ($words as $word) {
            $options[] = [
                'value' => $word->word,
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => '*'.ucfirst($word->word).'*',
                ],
                "description" => [
                    "type" => "plain_text",
                    "text" => 'Reting: '.$word->rating.' - '.($word->author ? 'Bedacht door vunzerik '.$word->author->name : 'Bedacht door anoniempje'),
                ],
            ];
        }

        $blocks = [
            [
                'type' => 'header',
                'text' => [
                    'type' => 'plain_text',
                    'text' => 'Tijd om te stemmen viezerikjes!',
                ],
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'plain_text',
                    'text' => 'Kies hieronder voor jouw favorietje:',
                ],
                'accessory' => [
                    'type' => 'radio_buttons',
                    'action_id' => 'poll',
                    'options' => $options,
                ]
            ],
        ];

        \Spatie\SlackAlerts\Facades\SlackAlert::blocks($blocks);
    }
}
