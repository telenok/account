<?php

// Login
app('router')->post('personal/account/login', array('as' => 'telenok.account.login', 'uses' => 'App\Telenok\Account\Widget\Login\Controller@postLogin'));
app('router')->get('personal/account/logout', array('as' => 'telenok.account.logout', 'uses' => 'App\Telenok\Account\Widget\Login\Controller@getLogout'));
app('router')->post('personal/account/password-restore', array('as' => 'telenok.auth.password-restore', 'uses' => 'App\Telenok\Account\Widget\Login\Controller@postLogin'));
app('router')->get('personal/account/redirect/social-network/{name}', array('as' => 'telenok.auth.redirect.social-network', 'uses' => 'App\Telenok\Account\Widget\Login\Controller@redirectSocialNetwork'));
app('router')->get('personal/account/login/social-network/callback/{name}', array('as' => 'telenok.auth.callback.social-network', 'uses' => 'App\Telenok\Account\Widget\Login\Controller@callbackSocialNetwork'));


