<?php

namespace App\Slack;

use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class RegisterHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return str_starts_with($request->text, 'viezerik');
    }

    public function handle(Request $request): Response
    {
        $argument = substr($request->text, strlen('viezerik'));

        return $this->respondToSlack("Je zei {$argument}!");
    }
}
