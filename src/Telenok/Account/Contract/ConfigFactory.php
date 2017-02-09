<?php

namespace Telenok\Account\Contract;

interface ConfigFactory
{
    /**
     * Create and return \SocialiteProviders\Manager\Config by name.
     *
     * @param  string $name Name of provider
     * @return \SocialiteProviders\Manager\Config
     */
    public function config($name);
}
