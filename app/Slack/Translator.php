<?php

namespace App\Slack;

use App\Models\Word;

class Translator
{
    public function translate(string $input): string
    {
        $word = Word::orderBy('created_at', 'asc')->first()->value('word');

        return str_replace([
            '{word}',
        ], [
            $word
        ], $input);
    }
}
