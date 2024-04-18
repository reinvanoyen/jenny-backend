<?php

namespace App\Slack;

use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class AllHandler extends BaseHandler
{
    protected $signature = '*';

    protected $description = 'Vertel mij eens waarover dit gaat?';

    public function canHandle(Request $request): bool
    {
        return true;
    }

    public function handle(Request $request): Response
    {
        return $this->respondToSlack('Welkom bij de Vetpotkast, waar we geen doekjes \'winden\' om vuile woorden. Tussen vetpot en pint, trekken we de beerput open en duiken we dieper in de betekenis, oorsprong en gedachten van de dark side van onze vocabulaire. We schuwen geen enkel woord, hoe welriekend het ook mag zijn. Graaf mee met ons in de smeuïge wereld van ons ziek brein en haal het donkerste, goorste, vuilste woord uit de kast. Hoe vettiger, hoe prettiger.')
            ->displayResponseToEveryoneOnChannel();
    }
}
