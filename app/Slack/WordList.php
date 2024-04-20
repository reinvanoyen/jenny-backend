<?php

namespace App\Slack;

class WordList
{
    /**
     * @var array
     */
    private array $words;

    public function __construct(array $words)
    {
        $this->words = $words;
    }

    public function output(): string
    {
        $output = [];

        foreach ($this->words as $index => $word) {
            $output[] = '* '.$word->created_at->format('j F Y H:i') . ' - *'.$word->word.'* (reting: '.$word->rating.')';
        }

        return join("\n", $output);
    }
}
