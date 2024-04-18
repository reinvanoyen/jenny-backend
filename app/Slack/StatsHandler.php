<?php

namespace App\Slack;

use App\Models\Word;
use Illuminate\Support\Str;
use Spatie\SlashCommand\Request;
use Spatie\SlashCommand\Response;
use Spatie\SlashCommand\Handlers\BaseHandler;

class StatsHandler extends BaseHandler
{
    protected $signature = '* de vuilste';

    protected $description = 'Toont een lijstje van de allervieste woorden';

    public function canHandle(Request $request): bool
    {
        return Str::startsWith($request->text, 'de vuilste');
    }

    public function handle(Request $request): Response
    {
        $words = Word::orderBy('rating', 'desc')->limit(5)->get();

        $output = [];

        foreach ($words as $index => $word) {
            $output[] = ($index + 1) . '. '.$word->word.' (reting: '.$word->rating.')';
        }

        return $this->respondToSlack(join("\n", $output))
                ->displayResponseToEveryoneOnChannel();
    }
}
