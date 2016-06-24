<?php

    app()->register('App\Vendor\Telenok\Account\CoreServiceProvider');

    $this->line('Package migrating', true);

    $this->call('migrate', [
        '--path' => 'vendor/telenok/account/src/migrations',
        '--force' => true
    ]);

    $this->line('Package assets publishing');

    $this->call('vendor:publish', [
        '--tag' => ['public'],
        '--provider' => 'App\Vendor\Telenok\Account\CoreServiceProvider',
        '--force' => true
    ]);