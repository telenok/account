<?php

namespace Telenok\Account\Contract;

interface ProviderFactory
{
    /**
     * Create and return \SocialiteProviders\Manager\OAuth1\AbstractProvider by name.
     *
     * @param  string $name Name of provider
     * @return \SocialiteProviders\Manager\OAuth1\AbstractProvider
     */
    public function create($name);
}
