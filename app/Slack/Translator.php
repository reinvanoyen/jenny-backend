<?php

namespace App\Slack;

use App\Models\Author;
use App\Models\Word;

class Translator
{
    public function translate(string $input): string
    {
        $word = Word::latest()->first()->word;
        $noun = Word::inRandomOrder()->first()->word;
        $verb = Word::inRandomOrder()->first()->word;
        $random = Word::inRandomOrder()->first()->word;
        $randomUser = Author::inRandomOrder()->first()->name;
        $count = Word::count();

        return str_replace([
            '{word}',
            '{noun}',
            '{verb}',
            '{random}',
            '{count}',
            '{randuser}',
        ], [
            $word,
            $noun,
            $verb,
            $random,
            $count,
            $randomUser,
        ], $input);
    }
}
