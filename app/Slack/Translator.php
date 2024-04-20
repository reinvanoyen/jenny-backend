<?php

namespace App\Slack;

use App\Models\Word;

class Translator
{
    public function translate(string $input): string
    {
        $word = Word::latest()->first()->word;
        $noun = Word::inRandomOrder()->first()->word;
        $verb = Word::inRandomOrder()->first()->word;
        $random = Word::inRandomOrder()->first()->word;
        $count = Word::count();

        return str_replace([
            '{word}',
            '{noun}',
            '{verb}',
            '{random}',
            '{count}',
        ], [
            $word,
            $noun,
            $verb,
            $random,
            $count,
        ], $input);
    }
}
