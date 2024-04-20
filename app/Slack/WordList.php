<?php

namespace App\Slack;

class WordList
{
    private $words;

    public function __construct($words)
    {
        $this->words = $words;
    }

    public function output($rank = true, $date = false, $rating = true, $author = true): string
    {
        $output = [];

        foreach ($this->words as $index => $word) {
            $row = [];

            if ($rank) {
                $row[] = ($index+1).'.';
            }

            $row[] = '*'.$word->word.'*';

            if ($date) {
                $row[] = '(toegevoegd: '.$word->created_at->format('j F Y H:i').')';
            }

            if ($rating) {
                $row[] = '(reting: '.$word->rating.')';
            }

            if ($author) {
                $row[] = $word->author ? '(door: '.$word->author->name.')' : '';
            }

            $output[] = join(' ', $row);
        }

        return join("\n", $output);
    }
}
