<?php

namespace App\Cmf\Meta;

use App\Models\Word;
use ReinVanOyen\Cmf\Components\TextField;
use ReinVanOyen\Cmf\Components\TextView;
use ReinVanOyen\Cmf\Meta;
use ReinVanOyen\Cmf\Searchers\LikeSearcher;
use ReinVanOyen\Cmf\Searchers\Searcher;
use ReinVanOyen\Cmf\Sorters\Sorter;
use ReinVanOyen\Cmf\Sorters\StaticSorter;

class WordMeta extends Meta
{
    /**
     * @var string $model
     */
    protected static $model = Word::class;

    /**
     * @var string $title
     */
    protected static $title = 'word';

    /**
     * @var int $perPage
     */
    protected static $perPage = 10;

    /**
     * @var int[] $indexGrid
     */
    protected static $indexGrid = [
        1, 1,
    ];

    /**
     * @return Searcher|null
     */
    public static function searcher(): ?Searcher
    {
        return new LikeSearcher(['word',]);
    }

    /**
     * @return string
     */
    public static function getSingular(): string
    {
        return 'Vies vuil woord';
    }

    /**
     * @return string
     */
    public static function getPlural(): string
    {
        return 'vieze vettige vuile woorden';
    }

    /**
     * @return Sorter
     */
    public static function sorter(): Sorter
    {
        return new StaticSorter(['rating' => 'desc',]);
    }

    /**
     * @return array
     */
    public static function index(): array
    {
        return [
            TextView::make('word')->style('primary'),
            TextView::make('rating'),
        ];
    }

    /**
     * @return array
     */
    public static function create(): array
    {
        return [
            TextField::make('word')->validate(['required',]),
        ];
    }
}
