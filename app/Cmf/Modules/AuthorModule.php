<?php

namespace App\Cmf\Modules;

use App\Cmf\Meta\AuthorMeta;
use ReinVanOyen\Cmf\Action\Action;
use ReinVanOyen\Cmf\Action\Delete;
use ReinVanOyen\Cmf\Action\Index;
use ReinVanOyen\Cmf\Action\Edit;
use ReinVanOyen\Cmf\Components\Icon;
use ReinVanOyen\Cmf\Module;

class AuthorModule extends Module
{
    /**
     * @return string
     */
    protected function title(): string
    {
        return 'Vunzige ventjes';
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
        return Index::make(AuthorMeta::class)
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
        return Delete::make(AuthorMeta::class);
    }

    /**
     * @return Action
     */
    public function edit(): Action
    {
        return Edit::make(AuthorMeta::class);
    }
}
