<?php

namespace App\Slack\Handlers;

use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class SilentModeOffHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'ge zijt zo stil');
    }

    public function handle(Request $request): Response
    {
        setting('silent', false);

        return $this->respondToSlack('Ah, nu wilt ge plots wel weer dat ik m\'n bek opentrek?! Oké, kzal ulder wat meer storen!')
            ->displayResponseToEveryoneOnChannel();
    }
}
