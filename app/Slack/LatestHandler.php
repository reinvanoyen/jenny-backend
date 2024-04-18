<?php

namespace App\Slack;

use App\Models\Word;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class LatestHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return Str::startsWith($request->text, 'de laatste');
    }

    public function handle(Request $request): Response
    {
        $number = trim(strtolower(substr($request->text, strlen('de laatste'))));
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
        ];
        $limit = $numbersMap[$number] ?? 5;
        $words = Word::orderBy('created_at', 'desc')->limit($limit)->get();

        $output = [];

        foreach ($words as $index => $word) {
            $output[] = '* '.$word->created_at->format('j F Y H:i') . ' - *'.$word->word.'* (reting: '.$word->rating.')';
        }

        return $this->respondToSlack(join("\n", $output))
                ->displayResponseToEveryoneOnChannel();
    }
}
