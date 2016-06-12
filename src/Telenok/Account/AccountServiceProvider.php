<?php namespace Telenok\Account;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
/**
 * @class Telenok.Account.AccountServiceProvider
 * Core service provider.
 * @extends Illuminate.Support.ServiceProvider
 */
class AccountServiceProvider extends ServiceProvider {

    public function __construct(Application $app)
    {
        parent::__construct($app);

        include __DIR__ . '/../../config/event.php';
    }

    /**
     * @method boot
     * Load config, routers, create singletons and others.
     * @return {void}
     * @member Telenok.Account.CoreServiceProvider
     */
    public function boot()
    {
        $this->publishes([realpath(__DIR__ . '/../../../resources/app') => app_path()], 'resourcesapp');
        $this->loadViewsFrom(realpath(__DIR__ . '/../../view'), 'account');

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
        $this->app->singleton('Telenok\Socialite\Contracts\Factory', function ($app) {
            return new \App\Telenok\Socialite\SocialiteManager($app);
        });
    }
}