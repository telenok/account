<?php

namespace Telenok\Account;

use SocialiteProviders\Manager\Contracts\Helpers\ConfigRetrieverInterface;
use App\Vendor\Telenok\Account\Manager\Helpers\ConfigRetriever as ConfigRetriever;

class SocialiteServiceProvider extends \SocialiteProviders\Manager\ServiceProvider
{
    public function register()
    {
        parent::register();

        $this->registerConfigFactory();
        $this->registerConfigRetriever();
    }

    protected function registerConfigFactory()
    {
        $this->app->singleton(\Telenok\Account\Contract\ConfigFactory::class, function () {
            return new \App\Vendor\Telenok\Account\Factory\Config();
        });
    }

    protected function registerConfigRetriever()
    {
        $this->app->singleton(ConfigRetrieverInterface::class, function () {
            return new ConfigRetriever(new \SocialiteProviders\Manager\Helpers\ConfigRetriever());
        });
    }

    public function provides()
    {
        return array_merge(parent::provides(), [\Telenok\Account\Contract\ConfigFactory::class]);
    }
}
