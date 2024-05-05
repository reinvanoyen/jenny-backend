<?php

namespace App\Cmf\Meta;

use App\Models\Reply;
use ReinVanOyen\Cmf\Components\EnumField;
use ReinVanOyen\Cmf\Components\EnumView;
use ReinVanOyen\Cmf\Components\TextField;
use ReinVanOyen\Cmf\Components\TextView;
use ReinVanOyen\Cmf\Meta;
use ReinVanOyen\Cmf\Searchers\LikeSearcher;
use ReinVanOyen\Cmf\Searchers\Searcher;

class ReplyMeta extends Meta
{
    /**
     * @var string $model
     */
    protected static $model = Reply::class;

    /**
     * @var string $title
     */
    protected static $title = 'text';

    /**
     * @var int $perPage
     */
    protected static $perPage = 10;

    /**
     * @return Searcher|null
     */
    public static function searcher(): ?Searcher
    {
        return new LikeSearcher(['text',]);
    }

    /**
     * @return string
     */
    public static function getSingular(): string
    {
        return 'Goor antwoord';
    }

    /**
     * @return string
     */
    public static function getPlural(): string
    {
        return 'Gore antwoorden';
    }

    /**
     * @return array
     */
    public static function index(): array
    {
        return [
            TextView::make('text'),
            EnumView::make('type', [
                Reply::TYPE_ADDED => 'Toevoeging',
                Reply::TYPE_DELETED => 'Verwijdering',
                Reply::TYPE_WOTD => 'Woord v/d dag',
                Reply::TYPE_HELP => 'Help',
                Reply::TYPE_DAILY => 'Dagelijks',
                Reply::TYPE_WEEKLY => 'Wekelijks',
                Reply::TYPE_FRIDAY => 'Vrijdag',
                Reply::TYPE_RANDOM => 'Willekeurig',
                Reply::TYPE_VOTED => 'Stem+',
                Reply::TYPE_DOWNVOTED => 'Stem-',
                Reply::TYPE_ARG => 'ARG Hint',
                Reply::TYPE_COUNT => 'Telling',
            ]),
        ];
    }

    /**
     * @return array
     */
    public static function create(): array
    {
        return [
            EnumField::make('type', [
                Reply::TYPE_ADDED => 'Toevoeging',
                Reply::TYPE_DELETED => 'Verwijdering',
                Reply::TYPE_WOTD => 'Woord v/d dag',
                Reply::TYPE_HELP => 'Help',
                Reply::TYPE_DAILY => 'Dagelijks',
                Reply::TYPE_WEEKLY => 'Wekelijks',
                Reply::TYPE_FRIDAY => 'Vrijdag',
                Reply::TYPE_RANDOM => 'Willekeurig',
                Reply::TYPE_VOTED => 'Stem+',
                Reply::TYPE_DOWNVOTED => 'Stem-',
                Reply::TYPE_ARG => 'ARG Hint',
                Reply::TYPE_COUNT => 'Telling',
            ]),
            TextField::make('text')->validate(['required',]),
        ];
    }
}
