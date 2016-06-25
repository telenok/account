<?php

    \Telenok\Core\Support\Install\Custom::recursiveCopy(__DIR__ . "/../app", __DIR__ . "/../../../../app/Vendor");
    \Telenok\Core\Support\Install\Custom::addListener('\App\Vendor\Telenok\Account\Event\Listener');
    \Telenok\Core\Support\Install\Custom::addServiceProvider('\App\Vendor\Telenok\Account\CoreServiceProvider');
