<?php

namespace App\Slack;

use App\Models\Word;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class RegisterHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return Str::startsWith($request->text, 'vies');
    }

    public function handle(Request $request): Response
    {
        $word = trim(strtolower(substr($request->text, strlen('vies'))));
        $segments = explode(' ', $word);

        $randomWord = Word::inRandomOrder()->first();
        $randomWordValue = ($randomWord ? $randomWord->word : 'krentenbaard');

        // Check if it's one word first
        if (count($segments) > 1) {
            return $this->respondToSlack('Eén woord, stukske '.$randomWordValue.'! Zo moeilijk kan da nu toch ni zijn?!')
                ->displayResponseToEveryoneOnChannel();
        }

        // Check if it already exists
        $wordModel = Word::where('word', $word)->first();

        if ($wordModel) {
            $wordModel->rating = $wordModel->rating + 1;
            $wordModel->save();

            return $this->respondToSlack('We hadden "'.$word.'" al. Beetje bij de pinken blijven he, mislukten '.$randomWordValue.'! Kheb het dan maar een extra puntje gegeven, wa moet ik anders doen?!')
                ->displayResponseToEveryoneOnChannel();
        }

        // Create the word
        $wordModel = new Word();
        $wordModel->word = $word;
        $wordModel->rating = 1;
        $wordModel->save();

        return $this->respondToSlack($this->randomSuccessReply($word, $randomWordValue))
            ->displayResponseToEveryoneOnChannel();
    }

    private function randomSuccessReply(string $word, string $randomWord)
    {
        $replies = [
            ucfirst($word).' ofwa? Ieeuw. Vies. Me wa zijt ge eigenlijk bezig? Maar allee, tis goe, kheb het opgeslaan in mijn '.$randomWord.'..euh ik bedoel database.',
            'Amai, goeike ze. Past goed bij '.$randomWord.'!',
            'Vunzig ventje. Of vrouwtje, weet ik veel. Hoe bedenkt ge zelf iets zo gortig als een '.$word.'?',
            'Bweikes, kben da ooit eens tegengekomen in de wc\'s van de charla. Maar oké, tzit in mijn database, ge kunt op mij rekenen.',
            'Geef mij liever nen emmer stront dan zo\'n '.$word.', maar enfin. Ik ben ook maar nen computer natuurlijk...',
            ucfirst($randomWord).'! Kheb mijn proper databaseke nu vies gemaakt met '.$word.'.',
            'Euh kweet niet of dat door de beugel kan hoor, maar ok...voor één keer ist goe. Viezerik.',
            '🤮🤮🤮',
            'Wow, uit welke vieze vleesgrot zijt ge dat woord gaan halen. Knap werk!',
            'Amai, we hebben een woordsmid in ons midden!',
            'Wow, vies stukske woordkunstenaar. Uw collega\'s zullen fier zijn op je!',
            'Ja, tzit erin, ok? Vetzak!',
            'Kheb het zonder spekelen in de database geduwd, ok? Content?',
            'De database wou het eerst niet aanvaarden, maar kheb het er toch in geforceerd.',
            'De database wou het woord niet, maar kheb het er dan toch gewoon met wat speeksel in gekregen.',
            'De database zegt dat het wat pijn had toen het erin ging, maar tis uiteindelijk toch gelukt.',
            'Kheb het in de database gekregen. Beetje vaseline doet wonderen.',
            '"'.ucfirst($word).'" zit nu bij de andere vieze woordjes in de '.$randomWord.', ik bedoel database!',
            $randomWord.'! '.$randomWord.'! '.$randomWord.'! '.$randomWord.'!',
            'Knap werk. Uw mama zal trots zijn.',
            'Bravo! Van alle dingen dat ge mij kunt komen zeggen komt ge af met '.$word.'...',
            'Chapeau. Ben echt jaloers op uw vieze vuile vindingrijkheid.',
            'Een gortige nieuwe entry in de database! De '.$randomWord.'-goden danken u.',
            'Ma echt, gaat dat er niet wat over?!',
            str_repeat($word, 10).'!!!!',
            'Vies!',
            'Vunzigaard!',
            'Ma allee, jezus, vetzakken hier allemaal!',
            'Hahaha, gij stukske '.$randomWord.'! Tis inorde jong, tzit erin. Viezerik hahaha!',
            'Ma echt, waar zijt ge mee bezig. '.ucfirst($word).'??? 🤮',
            '"Kakapipi" was niet avant-garde genoeg ofwa? Moet dat nu echt zo vunzig zijn als '.$word.'? Gij stukske '.$randomWord.'!',
        ];

        return $replies[array_rand($replies)];
    }
}
