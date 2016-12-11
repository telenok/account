<?php

    app('router')->post('personal/account/login', array('as' => 'telenok.account.login', 'uses' => 'App\Vendor\Telenok\Account\Widget\Login\Controller@postLogin'));
    app('router')->get('personal/account/logout', array('as' => 'telenok.account.logout', 'uses' => 'App\Vendor\Telenok\Account\Widget\Login\Controller@getLogout'));
    app('router')->post('personal/account/password-restore', array('as' => 'telenok.auth.password-restore', 'uses' => 'App\Vendor\Telenok\Account\Widget\Login\Controller@postLogin'));
    app('router')->get('personal/account/redirect/social-network/{name}', array('as' => 'telenok.auth.redirect.social-network', 'uses' => 'App\Vendor\Telenok\Account\Widget\Login\Controller@redirectSocialNetwork'));
    app('router')->get('personal/account/login/social-network/callback/{name}', array('as' => 'telenok.auth.callback.social-network', 'uses' => 'App\Vendor\Telenok\Account\Widget\Login\Controller@callbackSocialNetwork'));


    app('router')->post('personal/account/password-reset', array('as' => 'telenok.account.reset', 'uses' => 'App\Vendor\Telenok\Account\Widget\ResetPassword\Controller@postResetLinkEmail'));
    app('router')->get('personal/account/password-reset/process/{token}', array('as' => 'telenok.account.reset.process', 'uses' => 'App\Vendor\Telenok\Account\Widget\ResetPassword\Controller@redirectToResetForm'));
    app('router')->post('personal/account/password-reset/finish', array('as' => 'telenok.account.reset.finish', 'uses' => 'App\Vendor\Telenok\Account\Widget\ResetPassword\Controller@reset'));

