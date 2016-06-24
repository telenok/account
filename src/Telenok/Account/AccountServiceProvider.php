<?php namespace Telenok\Account;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use App\Vendor\Telenok\Account\Broker\PasswordBrokerManager;

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
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../../lang'), 'account');

        include __DIR__ . '/../../config/routes.php';
    }

    /**
     * @method register
     * Register the service provider.
     * @return {void}
     * @member Telenok.Account.CoreServiceProvider
     */
    public function register()
    {
        $this->app->singleton(\Telenok\Socialite\Contracts\Factory::class, function ($app) {
            return new \App\Vendor\Telenok\Account\Socialite\SocialiteManager($app);
        });

        $this->app->singleton('auth.password', function ($app) {
            return new PasswordBrokerManager($app);
        });
    }
}