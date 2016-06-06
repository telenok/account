<?php

    $this->line('Package new classes copy');

    $this->call('vendor:publish', [
        '--tag' => ['resourcesapp'], 
        '--provider' => 'Telenok\Account\AccountServiceProvider',
    ]);