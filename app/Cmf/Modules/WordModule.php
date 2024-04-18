<?php

namespace App\Cmf\Modules;

use App\Cmf\Meta\ProjectMeta;
use App\Cmf\Meta\WordMeta;
use ReinVanOyen\Cmf\Action\Action;
use ReinVanOyen\Cmf\Action\Delete;
use ReinVanOyen\Cmf\Action\Index;
use ReinVanOyen\Cmf\Action\Create;
use ReinVanOyen\Cmf\Action\Edit;
use ReinVanOyen\Cmf\Components\Icon;
use ReinVanOyen\Cmf\Module;
use ReinVanOyen\Cmf\Components\Link;

class WordModule extends Module
{
    /**
     * @return string
     */
    protected function title(): string
    {
        return 'Vieze vuile woorden';
    }

    /**
     * @return string
     */
    protected function icon()
    {
        return 'star';
    }

    /**
     * @return Action
     */
    public function index(): Action
    {
        return Index::make(WordMeta::class)
            ->header([
                Link::make('Nieuw vies vuil woord', 'create')
                    ->style('primary'),
            ])
            ->actions([
                Icon::make('edit')->to('edit'),
                Icon::make('delete')->to('delete'),
            ]);
    }

    /**
     * @return Action
     */
    public function delete(): Action
    {
        return Delete::make(WordMeta::class);
    }

    /**
     * @return Action
     */
    public function create(): Action
    {
        return Create::make(WordMeta::class);
    }

    /**
     * @return Action
     */
    public function edit(): Action
    {
        return Edit::make(WordMeta::class);
    }
}
