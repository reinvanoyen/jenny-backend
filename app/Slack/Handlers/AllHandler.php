<?php

namespace App\Slack\Handlers;

use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class AllHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return true;
    }

    public function handle(Request $request): Response
    {
        $client = \JoliCode\Slack\ClientFactory::create(config('app.slack_bot_token'));

        $client->chatPostMessage([
            'channel' => config('app.slack_channel_id'),
            'as_user' => true,
            'text' => $request->text,
        ]);

        return $this->respondToSlack('You told Jenny')
            ->displayResponseToEveryoneOnChannel();
    }
}
