<?php

namespace App\Slack\Handlers;

use App\Models\Word;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class ListHighestRatedHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'de vuilste');
    }

    public function handle(Request $request): Response
    {
        $number = trim(strtolower(substr($request->text, strlen('de vuilste'))));
        $numbersMap = [
            'twee' => 2,
            'drie' => 3,
            'vier' => 4,
            'vijf' => 5,
            'zes' => 6,
            'zeven' => 7,
            'acht' => 8,
            'negen' => 9,
            'tien' => 10,
            'vijftien' => 15,
            'twintig' => 20,
            'dertig' => 30,
            'veertig' => 40,
            'vijftig' => 50,
        ];
        $limit = $numbersMap[$number] ?? 5;
        $words = Word::orderBy('rating', 'desc')->limit($limit)->get();

        $output = [];

        foreach ($words as $index => $word) {
            $output[] = '* '.($index + 1) . '. *'.$word->word.'* (reting: '.$word->rating.')';
        }

        return $this->respondToSlack(join("\n", $output))
                ->displayResponseToEveryoneOnChannel();
    }
}
