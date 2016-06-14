<?php namespace Telenok\Account;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use App\Telenok\Account\Broker\PasswordBrokerManager;

/**
 * @class Telenok.Account.AccountServiceProvider
 * Core service provider.
 * @extends Illuminate.Support.ServiceProvider
 */
class AccountDeferredServiceProvider extends ServiceProvider {

    protected $defer = true;

    /**
     * @method register
     * Register the service provider.
     * @return {void}
     * @member Telenok.Account.CoreServiceProvider
     */
    public function register()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordBrokerManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth.password'];
    }
}