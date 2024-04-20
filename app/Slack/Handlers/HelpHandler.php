<?php

namespace App\Slack\Handlers;

use App\Models\Reply;
use App\Models\Word;
use App\Slack\Facades\Replier;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class HelpHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'help');
    }

    public function handle(Request $request): Response
    {
        $output = [
            Replier::reply(Reply::TYPE_HELP)."\n",
            '* Om een vatsig woord toe te voegen: `/vetbot vies [woord]`',
            '* Om een vurt woord te bekijken: `/vetbot toon [woord]`',
            '* Om een vettig staaltje taal te apprecieren: `/vetbot puntje voor [woord]`',
            '* Om een woord af te kraken: `/vetbot puntje aftrekken [woord]`',
            '* Om u aan mij voor te stellen: `/vetbot goeiendag ik ben [naam]`',
            '* Om de goorste woorden op te vragen: `/vetbot de vuilste` of `/vetbot de vuilste dertig`',
            '* Om de laatste woorden op te vragen: `/vetbot de laatste` of `/vetbot de laatste zeven`',
            '* Als een woord te proper is kunt ge het zo verwijderen: `/vetbot weg met [woord]` (let op: weg is weg)',
            '* Om een willekeurig vies woord naar uw hoofd gesmeten te krijgen: `/vetbot vuilaard`  of `/vetbot vuilaard geef er mij tien`',
            '* En als ge echt achterlijk zijt, om deze boodschap te tonen: `/vetbot help` of `/vetbot help mij dan toch ik ben dom`',
        ];

        return $this->respondToSlack(join("\n", $output))
            ->displayResponseToEveryoneOnChannel();
    }
}
