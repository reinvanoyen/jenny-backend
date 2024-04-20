<?php

namespace App\Providers;

use App\Cmf\Modules\AuthorModule;
use App\Cmf\Modules\ReplyModule;
use App\Cmf\Modules\WordModule;
use ReinVanOyen\Cmf\CmfApplicationServiceProvider;
use ReinVanOyen\Cmf\Modules\UserModule;
use ReinVanOyen\Cmf\Modules\MediaLibraryModule;

class CmfServiceProvider extends CmfApplicationServiceProvider
{
    public function modules(): array
    {
        return [
            WordModule::class,
            ReplyModule::class,
            AuthorModule::class,
            UserModule::class,
            MediaLibraryModule::class,
        ];
    }
}
