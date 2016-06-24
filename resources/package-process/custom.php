<?php

    \App\Vendor\Telenok\Core\Support\Install\Custom::recursiveCopy(__DIR__ . "/../app", __DIR__ . "/../../../../app/Vendor");
    \App\Vendor\Telenok\Core\Support\Install\Custom::addListener('\App\Vendor\Telenok\Account\Event\Listener');
    \App\Vendor\Telenok\Core\Support\Install\Custom::addServiceProvider('\App\Vendor\Telenok\Account\CoreServiceProvider');
