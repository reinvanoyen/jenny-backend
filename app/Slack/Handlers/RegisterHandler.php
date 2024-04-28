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
        $wordModel->author()->associate(\author($request->userId, $request->userName));
        $wordModel->save();

        // Word count
        $wordCount = Word::count();
        if ($wordCount === 200 && config('settings.level') < 2) {
            setting('level', 2);
            return $this->respondToSlack('JaAAAaAAAaAAAAAAAAAaaaaAAAAaaaAA!!!!! 200 woorden!')
                ->displayResponseToEveryoneOnChannel();
        }

        if ($wordCount === 300 && config('settings.level') < 3) {
            setting('level', 3);
            return $this->respondToSlack('LEVEL 3 MODDERFOKKERS')
                ->displayResponseToEveryoneOnChannel();
        }

        return $this->respondToSlack(Replier::reply(Reply::TYPE_ADDED))
            ->displayResponseToEveryoneOnChannel();
    }
}
