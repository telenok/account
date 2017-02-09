<?php

namespace Telenok\Account\Factory;

use \Telenok\Account\Contract\ProviderFactory;
use \Telenok\Account\Contract\ConfigFactory;
use Laravel\Socialite\Contracts\Factory as Socialite;

class Provider implements ProviderFactory
{
    protected $config;
    protected $socialite;

    public function __construct(Socialite $socialite, ConfigFactory $config)
    {
        $this->config = $config;
        $this->socialite = $socialite;
    }

    public function create($name, $additionalProviderConfig = [])
    {
        $this->socialite->with($name)->setConfig($this->config->config($name, $additionalProviderConfig))->redirect();
    }
}
