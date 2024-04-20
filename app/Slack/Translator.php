<?php

namespace App\Slack;

use App\Models\Word;

class Translator
{
    public function translate(string $input): string
    {
        $word = Word::orderBy('created_at', 'desc')->first()->value('word');
        $noun = Word::inRandomOrder()->first()->value('word');
        $verb = Word::inRandomOrder()->first()->value('word');
        $random = Word::inRandomOrder()->first()->value('word');

        return str_replace([
            '{word}',
            '{noun}',
            '{verb}',
            '{random}',
        ], [
            $word,
            $noun,
            $verb,
            $random
        ], $input);
    }
}
