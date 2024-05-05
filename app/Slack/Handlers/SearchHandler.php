<?php

namespace App\Slack\Handlers;

use App\Models\Word;
use App\Slack\WordList;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class SearchHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'zoek');
    }

    public function handle(Request $request): Response
    {
        $word = trim(strtolower(substr($request->text, strlen('zoek'))));
        $segments = explode(' ', $word);

        if ($word === 'afkolven') {
            return $this->respondToSlack('F@1Jom0dl ZaxKduUhoZkuW, F3g AfzNoeW NufAh Zo PxoNdeEfuR 96. D@uW Fuv Znu Ax Fuk FouUdkWi?')
                ->displayResponseToEveryoneOnChannel();
        }

        // Check if it's one word first
        if (count($segments) > 1) {
            return $this->respondToSlack('Eén woord! Zo moeilijk kan da nu toch ni zijn?!')
                ->displayResponseToEveryoneOnChannel();
        }

        $words = Word::orderBy('created_at', 'desc')->where('word', 'like', '%'.$word.'%')->get();

        $wordList = new WordList($words);

        return $this->respondToSlack($wordList->output(false, false, true, true))
                ->displayResponseToEveryoneOnChannel();
    }
}
