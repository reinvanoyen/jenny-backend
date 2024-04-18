<?php

namespace App\Slack;

use App\Models\Word;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class HelpHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return Str::startsWith($request->text, 'help');
    }

    public function handle(Request $request): Response
    {
        $randomWord = Word::inRandomOrder()->first();
        $randomWordValue = ($randomWord ? $randomWord->word : 'krentenbaard');

        $output = [
            'Komaaaan zeg bedorven stukske '.$randomWordValue.', moet ik nu altijd uw handje vasthouden?!'."\n",
            '* Om een vatsig woord toe te voegen: `/vetbot vies [woord]`',
            '* Om de goorste woorden op te vragen: `/vetbot de vuilste`',
            '* Om de laatste woorden op te vragen: `/vetbot de laatste`',
            '* Om een willekeurig vies woord naar uw hoofd gesmeten te krijgen: `/vetbot vuilaard`',
            '* En als ge echt achterlijk zijt, om deze boodschap te tonen: `/vetbot help` of `/vetbot help mij dan toch ik ben dom`',
        ];

        return $this->respondToSlack(join("\n", $output))
            ->displayResponseToEveryoneOnChannel();
    }
}
