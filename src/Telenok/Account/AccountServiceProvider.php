<?php namespace Telenok\Account;

use App\Vendor\Telenok\Account\Event\Subscribe;
use App\Vendor\Telenok\Account\Broker\PasswordBrokerManager;
use Illuminate\Support\ServiceProvider;
/**
 * @class Telenok.Account.AccountServiceProvider
 * Core service provider.
 * @extends Illuminate.Support.ServiceProvider
 */
class AccountServiceProvider extends ServiceProvider {

    /**
     * @method boot
     * Load config, routers, create singletons and others.
     * @return {void}
     * @member Telenok.Account.CoreServiceProvider
     */
    public function boot()
    {
        $this->publishes([realpath(__DIR__ . '/../../../public') => public_path('packages/telenok/account')], 'public');
        $this->publishes([realpath(__DIR__ . '/../../../resources/app') => app_path()], 'resourcesapp');
        $this->loadViewsFrom(realpath(__DIR__ . '/../../view'), 'account');
        $this->loadRoutesFrom(__DIR__ . '/../../config/routes.php');
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../../lang'), 'account');
    }

    /**
     * @method register
     * Register the service provider.
     * @return {void}
     * @member Telenok.Account.CoreServiceProvider
     */
    public function register()
    {
        $this->registerAuthPassword();
    }


    public function registerAuthPassword()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordBrokerManager($app);
        });
    }
}