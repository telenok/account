<?php

\Telenok\Core\Support\Install\ComposerScripts::recursiveCopy(__DIR__ . "/../app", __DIR__ . "/../../../../../app/Vendor");
\Telenok\Core\Support\Install\ComposerScripts::addServiceProvider('\App\Vendor\Telenok\Account\AccountServiceProvider::class');
\Telenok\Core\Support\Install\ComposerScripts::addServiceProvider('\App\Vendor\Telenok\Account\SocialiteServiceProvider::class');
