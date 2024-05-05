<?php

namespace App\Slack\Handlers;

use App\Models\Reply;
use App\Slack\Facades\Replier;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class CountHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'hoeveel');
    }

    public function handle(Request $request): Response
    {
        return $this->respondToSlack(Replier::reply(Reply::TYPE_COUNT))
            ->displayResponseToEveryoneOnChannel();
    }
}
