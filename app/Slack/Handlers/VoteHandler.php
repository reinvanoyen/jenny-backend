<?php

namespace App\Slack\Handlers;

use App\Models\Reply;
use App\Models\Word;
use App\Slack\Facades\Replier;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class VoteHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'puntje voor');
    }

    public function handle(Request $request): Response
    {
        $word = trim(strtolower(substr($request->text, strlen('puntje voor'))));
        $segments = explode(' ', $word);

        // Check if it's one word first
        if (count($segments) > 1) {
            return $this->respondToSlack('Eén woord! Zo moeilijk kan da nu toch ni zijn?!')
                ->displayResponseToEveryoneOnChannel();
        }

        // Check if it exists
        $wordModel = Word::where('word', $word)->first();

        if ($wordModel) {
            $wordModel->rating = $wordModel->rating + 1;
            $wordModel->save();

            return $this->respondToSlack(Replier::reply(Reply::TYPE_VOTED))
                ->displayResponseToEveryoneOnChannel();
        }

        return $this->respondToSlack('Kheb da woord ni eens gevonden...beetje opletten als ge wilt?!')
            ->displayResponseToEveryoneOnChannel();

    }
}
