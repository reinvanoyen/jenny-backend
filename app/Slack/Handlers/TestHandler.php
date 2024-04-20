<?php

namespace App\Slack\Handlers;

use App\Models\Author;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class TestHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'test');
    }

    public function handle(Request $request): Response
    {
        $userId = $request->userId;
        $userName = $request->userName;

        $author = Author::firstOrCreate(
            ['slack_id' => $userId],
            ['name' => $userName]
        );

        return $this->respondToSlack($author->userName . ' – ' . $author->slack_id)
            ->displayResponseToEveryoneOnChannel();
    }
}
