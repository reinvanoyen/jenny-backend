<?php

namespace App\Slack;

use App\Models\Word;

class Translator
{
    public function translate(string $input): string
    {
        $word = Word::latest()->first()->get()->value('word');
        $noun = Word::inRandomOrder()->first()->get()->value('word');
        $verb = Word::inRandomOrder()->first()->get()->value('word');
        $random = Word::inRandomOrder()->first()->get()->value('word');

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
