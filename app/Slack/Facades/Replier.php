<?php

namespace App\Slack\Facades;

use Illuminate\Support\Facades\Facade;

class Replier extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \App\Slack\Replier::class;
    }
}
