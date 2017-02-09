<?php

namespace Telenok\Account;

use SocialiteProviders\Manager\Contracts\Helpers\ConfigRetrieverInterface;
use App\Vendor\Telenok\Account\Manager\Helpers\ConfigRetriever as ConfigRetriever;

class SocialiteServiceProvider extends \SocialiteProviders\Manager\ServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->singleton(ConfigRetrieverInterface::class, function () {
            return new ConfigRetriever(new \SocialiteProviders\Manager\Helpers\ConfigRetriever());
        });
    }
}
