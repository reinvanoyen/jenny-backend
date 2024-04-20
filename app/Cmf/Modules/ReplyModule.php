<?php

namespace App\Cmf\Modules;

use App\Cmf\Meta\ReplyMeta;
use App\Cmf\Meta\WordMeta;
use ReinVanOyen\Cmf\Action\Action;
use ReinVanOyen\Cmf\Action\Delete;
use ReinVanOyen\Cmf\Action\Index;
use ReinVanOyen\Cmf\Action\Create;
use ReinVanOyen\Cmf\Action\Edit;
use ReinVanOyen\Cmf\Components\Icon;
use ReinVanOyen\Cmf\Module;
use ReinVanOyen\Cmf\Components\Link;

class ReplyModule extends Module
{
    /**
     * @return string
     */
    protected function title(): string
    {
        return 'Gore antwoorden';
    }

    /**
     * @return string
     */
    protected function icon()
    {
        return 'emoji_objects';
    }

    /**
     * @return Action
     */
    public function index(): Action
    {
        return Index::make(ReplyMeta::class)
            ->header([
                Link::make('Nieuw onsympathiek antwoord', 'create')
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
        return Delete::make(ReplyMeta::class);
    }

    /**
     * @return Action
     */
    public function create(): Action
    {
        return Create::make(ReplyMeta::class);
    }

    /**
     * @return Action
     */
    public function edit(): Action
    {
        return Edit::make(ReplyMeta::class);
    }
}
