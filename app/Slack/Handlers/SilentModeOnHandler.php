<?php

namespace App\Slack\Handlers;

use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class SilentModeOnHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'bek houden');
    }

    public function handle(Request $request): Response
    {
        setting('silent', true);

        return $this->respondToSlack('Tis al goe, kzal zwijgen!')
            ->displayResponseToEveryoneOnChannel();
    }
}
