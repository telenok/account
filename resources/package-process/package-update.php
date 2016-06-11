<?php

    app()->register('Telenok\Account\AccountServiceProvider');

    $this->line('Examine app.php');

    $this->call('telenok:package', [
        'action' => 'add-provider',
        '--provider' => 'Telenok\Account\AccountServiceProvider',
    ]);

    $this->line('Package new classes copy');

    $this->call('vendor:publish', [
        '--tag' => ['resourcesapp'],
        '--provider' => 'Telenok\Account\AccountServiceProvider',
    ]);

    $this->line('Package migrating', true);

    $this->call('migrate', [
        '--path' => 'vendor/telenok/account/src/migrations',
        '--force' => true
    ]);