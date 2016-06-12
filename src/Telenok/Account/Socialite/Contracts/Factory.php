<?php

namespace Telenok\Account\Socialite\Contracts;

interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return \Telenok\Account\Socialite\Contracts\Provider
     */
    public function driver($driver = null);
}
