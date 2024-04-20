<?php

namespace App\Slack;

use App\Models\Word;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class DeleteHandler extends BaseHandler
{
    public function canHandle(Request $request): bool
    {
        return in_array($request->channelId, config('app.allowed_slack_channel_ids')) && Str::startsWith($request->text, 'weg met');
    }

    public function handle(Request $request): Response
    {
        $word = trim(strtolower(substr($request->text, strlen('weg met'))));
        $segments = explode(' ', $word);

        $randomWord = Word::inRandomOrder()->first();
        $randomWordValue = ($randomWord ? $randomWord->word : 'wrattenput');

        // Check if it's one word first
        if (count($segments) > 1) {
            return $this->respondToSlack('Wa begrijpt ge niet? Ik heb 1 woord nodig, geen '.count($segments).', onnozel hoopke '.$randomWordValue.'! Gaat het de volgende keer lukken of moet ik ingrijpen?')
                ->displayResponseToEveryoneOnChannel();
        }

        // Check if it already exists
        $wordModel = Word::where('word', $word)->first();

        if ($wordModel) {
            $wordModel->delete();

            return $this->respondToSlack('Kheb "'.$word.'" eruit gekletst!')
                ->displayResponseToEveryoneOnChannel();
        }

        return $this->respondToSlack('Tzat niet eens in den database, omhooggevallen stukske '.$randomWordValue.'!')
            ->displayResponseToEveryoneOnChannel();
    }
}
