<?php

app('events')->listen('telenok.repository.package', function($list)
{
    $list->push('Telenok\Account\PackageInfo');
});

app('events')->listen('telenok.repository.setting', function($list)
{
    $list->push('App\Telenok\Account\Setting\SocialNetwork\Controller');
});
