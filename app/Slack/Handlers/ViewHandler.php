<?php

namespace App\Slack\Handlers;

use App\Models\Reply;
use App\Models\Word;
use App\Slack\Facades\Replier;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Attachment;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class ViewHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'toon');
    }

    public function handle(Request $request): Response
    {
        $word = trim(strtolower(substr($request->text, strlen('toon'))));
        $segments = explode(' ', $word);

        // Check if it's one word first
        if (count($segments) > 1) {
            return $this->respondToSlack('Eén woord! Zo moeilijk kan da nu toch ni zijn?!')
                ->displayResponseToEveryoneOnChannel();
        }

        // Check if it exists
        $wordModel = Word::where('word', $word)->first();

        if ($wordModel) {
            return $this->respondToSlack(Replier::reply(Reply::TYPE_DOWNVOTED))
                ->withAttachment(Attachment::create()
                    ->setTitle($wordModel->word)
                    ->setColor('#4e4f30')
                    ->setAuthorName($wordModel->author ? $wordModel->author->name : '')
                    ->setText($wordModel->text)
                )
                ->displayResponseToEveryoneOnChannel();
        }

        return $this->respondToSlack('Kheb da woord ni eens gevonden...beetje opletten als ge wilt?!')
            ->displayResponseToEveryoneOnChannel();

    }
}
