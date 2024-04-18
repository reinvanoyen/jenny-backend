<?php

namespace App\Providers;

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
            UserModule::class,
            MediaLibraryModule::class,
        ];
    }
}
