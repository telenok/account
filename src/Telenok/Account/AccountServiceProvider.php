<?php namespace Telenok\Account;

use Illuminate\Support\ServiceProvider;

/**
 * @class Telenok.Account.AccountServiceProvider
 * Core service provider.
 * @extends Illuminate.Support.ServiceProvider
 */
class AccountServiceProvider extends ServiceProvider {

    protected $defer = false;

    /**
     * @method boot
     * Load config, routers, create singletons and others.
     * @return {void}
     * @member Telenok.Account.CoreServiceProvider
     */
    public function boot()
    {
        $this->publishes([realpath(__DIR__ . '/../../../resources/app') => app_path()], 'resourcesapp');
    }

    /**
     * @method register
     * Register the service provider.
     * @return {void}
     * @member Telenok.Account.CoreServiceProvider
     */
    public function register()
    {
    }

    /**
     * @method provides
     * Get the services provided by the provider.
     * @return {Array}
     * @member Telenok.Account.CoreServiceProvider
     */
    public function provides()
    {
        return [];
    }
}