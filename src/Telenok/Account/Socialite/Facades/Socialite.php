<?php

namespace Telenok\Account\Socialite\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Telenok\Account\Socialite\SocialiteManager
 */
class Socialite extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Telenok\Account\Socialite\Contracts\Factory';
    }
}
