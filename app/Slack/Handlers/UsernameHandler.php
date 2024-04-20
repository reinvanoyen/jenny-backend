<?php

namespace App\Slack\Handlers;

use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class UsernameHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'goeiendag ik ben');
    }

    public function handle(Request $request): Response
    {
        $word = trim(strtolower(substr($request->text, strlen('goeiendag ik ben'))));
        $segments = explode(' ', $word);

        // Check if it's one word first
        if (count($segments) > 2) {
            return $this->respondToSlack('Maximum 2 woorden! Zo moeilijk kan da nu toch ni zijn?!')
                ->displayResponseToEveryoneOnChannel();
        }

        $author = \author($request->userId, $request->userName);
        $author->name = join(' ', $segments);
        $author->save();

        return $this->respondToSlack('Goeiendag '.$author->name.'!')
            ->displayResponseToEveryoneOnChannel();
    }
}
