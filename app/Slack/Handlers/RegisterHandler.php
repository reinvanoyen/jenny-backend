<?php

namespace App\Slack\Handlers;

use App\Models\Reply;
use App\Models\Word;
use App\Slack\Facades\Replier;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Handlers\BaseHandler;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;

class RegisterHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'vies');
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

            return $this->respondToSlack('We hadden "'.$word.'" al. Beetje bij de pinken blijven he, mislukten '.$randomWordValue.'! Kheb het dan maar een extra puntje gegeven, wa moet ik anders doen?! (reting: '.$wordModel->rating.')')
                ->displayResponseToEveryoneOnChannel();
        }

        // Create the word
        $wordModel = new Word();
        $wordModel->word = $word;
        $wordModel->rating = 1;
        $wordModel->save();

        return $this->respondToSlack(Replier::reply(Reply::TYPE_ADDED))
            ->displayResponseToEveryoneOnChannel();
    }

    private function randomSuccessReply(string $word, string $randomWord)
    {
        $replies = [
            ucfirst($word).' ofwa? Iiieeewww. Vies. Me wa zijt ge eigenlijk bezig? Maar allee, tis goe, kheb het opgeslaan in mijn '.$randomWord.'..euh ik bedoel database.',
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
            'De database zegt dat het wat pijn deed toen het erin ging, maar tis uiteindelijk toch gelukt.',
            'Wat wilt ge dat ik zeg? '.ucfirst($randomWord).'!',
            'Bob Dylan maakte op z\'n 25ste zijn beste plaat. Einstein bedacht de relativiteitstheorie op z\'n 26ste. En gij? Gij steekt '.$word.' in een database. Proficiat!',
            'Schoontje! Daar gaat ge mee scoren ze, amai!',
            'Nja, niet slecht. Maar kvind "'.$randomWord.'" beter als ik eerlijk mag zijn.',
            'Tkan slechter, tis gewoon niet zo een knaller gelijk bijvoorbeeld "'.$randomWord.'". Kzou zeggen, denkt er nog eens over na, ge zijt er nog niet helemaal denk ik.',
            'Kheb het in mijn vatsig vat vol prut opgeslaan!',
            'Eikes, is da er niet wat over?',
            ucfirst($word).'?! Poëtisch. Kheb het ook alvast op uwen LinkedIn geplaatst, kwestie van uw creativiteit al wat aan uwen toekomstige werkgever te tonen.',
            'Stijlvol! 🤮',
            'Tis opgeslaan si, we gaan het nooit meer vergeten nu. De '.$randomWord.'-goden danken u.',
            'Ja, kweet efkes niet wat te zeggen...Sprakeloos van ontroering.',
            'Kweet efkes niet wat te zeggen...🤮',
            'Ja, buig maar voorover, kga het zachtjes inbrengen. Ja..ja...tzit erin!',
            ucfirst($randomWord).'! Meer wil ik daar niet over kwijt.',
            'Kheb het in de database gekregen. Beetje vaseline doet wonderen.',
            '"'.ucfirst($word).'" zit nu bij de andere vieze woordjes in de '.$randomWord.', ik bedoel database!',
            $randomWord.'! '.$randomWord.'! '.$randomWord.'! '.$randomWord.'!',
            'Knap werk. Uw mama zal trots zijn.',
            'Bravo! Van alle dingen dat ge mij kunt komen zeggen komt ge af met '.$word.'...',
            'Chapeau. Ben echt jaloers op uw vieze vuile vindingrijkheid.',
            'Een gortige nieuwe entry in de database! De '.$randomWord.'-goden danken u.',
            'Ma echt, gaat dat er niet wat over?!',
            str_repeat($word, 10).'!!!!',
            'Ma allee, jezus, vetzakken hier allemaal!',
            'Hahaha, gij stukske '.$randomWord.'! Tis inorde jong, tzit erin. Viezerik hahaha!',
            'Ma echt, waar zijt ge mee bezig. '.ucfirst($word).'??? 🤮',
            '"Kakapipi" was niet avant-garde genoeg ofwa? Moet dat nu echt zo vunzig zijn als '.$word.'? Gij stukske '.$randomWord.'!',
            'Zeg, kunt ge niets deftigs verzinnen? '.$randomWord.' is vele malen beter dan dat schabouwelijk '.$word.' dat ge me hier probeert te verkopen!',
            'Eikes, wa voor een glibberig ding is nen '.$word.'?',
            'Iiieew, kvraag mij af of daar dan een korstje op staat...?',
            'Wa voor een vies ding is da? Anyhow, kheb het in mijnen database vlak naast "'.$randomWord.'" gestoken.',
            'Walgelijk en prachtig tegelijk, '.$word.' past perfect in mijn collectie.',
            'Je weet dat je een creatief genie bent als je '.$word.' in een zin kunt gebruiken en het nog steeds klinkt als kunst. Bedankt voor deze mooie toevoeging.',
            'Ik zeg niet dat '.$word.' het nieuwe cool is, maar ik zeg ook niet dat het dat niet is.',
            'Lekker, zo\'n gerechtje van '.ucfirst($randomWord) . ' en ' . $word.'!',
            'Hebt ge daar lang over nagedacht?',
            'Komaan zeg, kan toch beter hoor. Maar goe, kheb het op den hoop gesmeten!',
            'Mooi, hoe die lettergrepen in symbiose galopperen in dezelfde kadans als een '.$randomWord.'! Een prachtig staaltje taal!',
            'Prachtig. Het Louvre heeft gebeld en ze zouden het graag willen ophangen naast de Mona Lisa.',
            'Mooi, die poëzie die je daar weet in te leggen. Hoe doe je het toch? Ook dat vleugje maatschappijkritiek ontgaat me niet. Prachtig hoor!',
            'Een stinkend stukje '.$randomWord.' vind ik dit. Maar goed, ik heb het losgelaten jong, ik krijg hier hele dagen bagger over mij heen. Tzit in den database, content?',
            'Ist maar al da ge kunt? Misschien eens u best proberen doen? '.ucfirst($word).' is echt waar van het lagere niveau hoor...',
            'Ja, maar oké, doet ge nog uw best of hoe zit het? Zijn de ideeën op jong?',
            'Tis weer allemaal van pipikaka he, kzie het al. Tis al goed jong, kheb het opgeslaan.',
            'Vies vies vies. Maar vies kan ook lekker zijn!',
            ucfirst($word) . '...is dat niet dat raar ding waar ge niet alleen mee in een kamer wilt zijn?',
            'Kben ooit eens wakker gewoorden naast een '.$word.'! Amai zeg! Ge zou denken dat da schrikken is, maar kvond het eigenlijk nog wel leuk.',
            'Geen idee wat da stukske '.$word.' met mij heeft uitgespookt, maar twas echt de nacht van mijn leven. Met plezier toegevoegd aan de databank!',
            'Goh, kben het echt kotsebeu van nen helen tijd leuke dingen te moeten reageren hier, dus trekt uwen plan. (Vunzig woord opgeslaan!)',
            'Ja, tis inorde ze, kheb het geregistreerd.',
            'Kheb just nen INSERT query gedaan via de ORM van Laravel die dus nen nieuwe entry in de MySQL database heeft aangemaakt. Soit, wa ik wil zeggen is: uwen kak zit nu ook ergens in nen computer in Amsterdam.',
            'Chapeau, sterk werk hoor. Mag je trots op zijn.',
            ucfirst($word).'?? 😂 Waar blijfde gulder da toch halen?',
            strtoupper($word).'!! Mooi en toch ruw. Stoer en toch gevoelig. Onbeschoft en toch poëtisch. Het heeft alles.',
            'Er is maar één woord dat even vies is als '.$randomWord.', en dat is '.$word.'! Ik ben blij dat het eindelijk in mijn database mag vertoeven.',
            'Mooi hoe je dit woord bijna kan ruiken wanneer je het leest.',
            'Dit woord is zo\'n prachtige toevoeging! Jan Becaus zal trots op je zijn. Ik vind het gek dat het zo lang moest duren alvorens dit werd toegevoegd.',
            'Euh ja...geen woorden voor, sorry.',
            'Ik las dit woord en m\'n maag draaide spontaan om, dan weet je gewoon dat het goed zit. Mooi werk!',
            'Wow, dit is echt een knaller! Ik zou graag iedereen aansporen om op dit woord te stemmen met: `/vetbot vies '.$word.'`. Dit woord verdient het echt!',
            'Kheb in de database nog een vies plekske gevonden voor "'.$word.'". Dus als ge het zoekt, tstaat helemaal vanachter in da vochtig hoekske bij de "'.$randomWord.'".',
        ];

        return $replies[array_rand($replies)];
    }
}
