<?php

namespace Telenok\Account\Factory;

use \Telenok\Account\Contract\ProviderFactory;
use \Telenok\Account\Contract\ConfigFactory;

class Provider implements ProviderFactory
{
    protected $config;

    public function __construct(ConfigFactory $config)
    {
        $this->config = $config;
    }

    public function create($name, $additionalProviderConfig = [])
    {
        $provider = app(\Laravel\Socialite\Contracts\Factory::class)->with($name);

        if (method_exists($provider, 'setConfig'))
        {
            $provider->setConfig($this->config->config($name, $additionalProviderConfig));
        }

        return $provider;
    }
}
