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