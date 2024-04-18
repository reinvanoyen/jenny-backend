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
        return Str::startsWith($request->text, 'vuilaard');
    }

    public function handle(Request $request): Response
    {
        $randomWord = Word::inRandomOrder()->first();
        $randomWordValue = ($randomWord ? $randomWord->word : 'krentenbaard');

        return $this->respondToSlack($randomWordValue . ' (reting: '.$randomWord->rating.' vieze punten)')
            ->displayResponseToEveryoneOnChannel();
    }
}
