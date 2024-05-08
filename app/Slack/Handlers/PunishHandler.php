<?php

namespace App\Slack\Handlers;

use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class PunishHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'straffen voor');
    }

    public function handle(Request $request): Response
    {
        $word = trim(strtolower(substr($request->text, strlen('straffen voor'))));
        $segments = explode(' ', $word);

        // Check if it's one word first
        if (count($segments) > 1) {
            return $this->respondToSlack('Eén woord! Zo moeilijk kan da nu toch ni zijn?!')
                ->displayResponseToEveryoneOnChannel();
        }

        return $this->respondToSlack('Ik ben nu gestraft voor '.$word)
            ->displayResponseToEveryoneOnChannel();

    }
}
