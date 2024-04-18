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
        return Str::startsWith($request->text, 'viezerik');
    }

    public function handle(Request $request): Response
    {

        $word = strtolower(substr($request->text, strlen('viezerik')));
        $segments = explode($word, ' ');


        $randomWord = Word::inRandomOrder()->first();
        $randomWordValue = ($randomWord ? $randomWord->word : 'krentenbaard');

        // Check if it's one word first
        if (count($segments) > 1) {
            return $this->respondToSlack('Eén woord, stukske '.$randomWordValue.'!');
        }

        return $this->respondToSlack('OK...');

        // Check if it already exists
        $wordModel = Word::where('word', $word)->first();

        if ($wordModel) {
            $wordModel->rating = $wordModel->rating + 1;
            $wordModel->save();

            return $this->respondToSlack('We hadden "'.$word.'" al. Beetje bij de pinken blijven he, mislukten '.$randomWordValue.'! Kheb het dan maar een extra puntje gegeven, wa moet ik anders doen?!');
        }

        // Create the word
        $wordModel = new Word();
        $wordModel->word = $word;
        $wordModel->rating = 1;
        $wordModel->save();

        return $this->respondToSlack($word. ' ofwa? Ieeuw. Me wa zijt ge eigenlijk bezig? Maar allee, tis goe, kheb het opgeslaan in mijn '.$randomWordValue.'..euh ik bedoel database.');
    }
}
