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
        $author = author($request->userId, $request->userName);

        return $this->respondToSlack('Nee '.$author->name.', voor u mag ik een mysterie blijven...')
            ->displayResponseToEveryoneOnChannel();
    }
}
