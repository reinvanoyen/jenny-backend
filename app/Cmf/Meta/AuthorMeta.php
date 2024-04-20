<?php

namespace App\Cmf\Meta;

use App\Models\Author;
use App\Models\Reply;
use ReinVanOyen\Cmf\Components\EnumField;
use ReinVanOyen\Cmf\Components\EnumView;
use ReinVanOyen\Cmf\Components\TextField;
use ReinVanOyen\Cmf\Components\TextView;
use ReinVanOyen\Cmf\Meta;
use ReinVanOyen\Cmf\Searchers\LikeSearcher;
use ReinVanOyen\Cmf\Searchers\Searcher;

class AuthorMeta extends Meta
{
    /**
     * @var string $model
     */
    protected static $model = Author::class;

    /**
     * @var string $title
     */
    protected static $title = 'name';

    /**
     * @var int $perPage
     */
    protected static $perPage = 10;

    /**
     * @return Searcher|null
     */
    public static function searcher(): ?Searcher
    {
        return new LikeSearcher(['name',]);
    }

    /**
     * @return string
     */
    public static function getSingular(): string
    {
        return 'Vunzige gebruiker';
    }

    /**
     * @return string
     */
    public static function getPlural(): string
    {
        return 'Vieze gebruikertjes';
    }

    /**
     * @return array
     */
    public static function index(): array
    {
        return [
            TextView::make('name'),
        ];
    }

    /**
     * @return array
     */
    public static function create(): array
    {
        return [
            TextField::make('name')->validate(['required',]),
        ];
    }
}
