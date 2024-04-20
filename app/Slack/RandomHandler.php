<?php

namespace App\Slack;

use App\Models\Word;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class RandomHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'vuilaard');
    }

    public function handle(Request $request): Response
    {
        $number = trim(strtolower(substr($request->text, strlen('vuilaard'))));
        $numbersMap = [
            'geef er mij twee' => 2,
            'geef er mij drie' => 3,
            'geef er mij vier' => 4,
            'geef er mij vijf' => 5,
            'geef er mij zes' => 6,
            'geef er mij zeven' => 7,
            'geef er mij acht' => 8,
            'geef er mij negen' => 9,
            'geef er mij tien' => 10,
        ];
        $limit = $numbersMap[$number] ?? 1;
        $words = Word::inRandomOrder()->limit($limit)->get();

        $output = [
            'Ge zijt zelf nen vuilaard! Hierzie:'."\n",
        ];

        foreach ($words as $index => $word) {
            $output[] = '* *'.$word->word.'* (reting: '.$word->rating.')';
        }

        return $this->respondToSlack(join("\n", $output))
            ->displayResponseToEveryoneOnChannel();
    }
}
