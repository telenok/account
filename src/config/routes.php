<?php

app('router')->post('personal/account/login', 'App\Vendor\Telenok\Account\Widget\Login\Controller@postLogin')->name('telenok.account.login');
app('router')->get('personal/account/logout', 'App\Vendor\Telenok\Account\Widget\Login\Controller@getLogout')->name('telenok.account.logout');
app('router')->post('personal/account/password-restore', 'App\Vendor\Telenok\Account\Widget\Login\Controller@postLogin')->name('telenok.account.password-restore');

app('router')->get('personal/account/redirect/social-network/{name}', 'App\Vendor\Telenok\Account\Widget\Login\Controller@redirectToProvider')->name('telenok.account.redirect-to-provider');
app('router')->get('personal/account/login/social-network/callback/{name}', 'App\Vendor\Telenok\Account\Widget\Login\Controller@handleProviderCallback')->name('telenok.account.handle-provider-callback');

app('router')->post('personal/account/password-reset', 'App\Vendor\Telenok\Account\Widget\ResetPassword\Controller@postResetLinkEmail')->name('telenok.account.reset');
app('router')->get('personal/account/password-reset/process/{token}', 'App\Vendor\Telenok\Account\Widget\ResetPassword\Controller@redirectToResetForm')->name('telenok.account.reset.process');
app('router')->post('personal/account/password-reset/finish', 'App\Vendor\Telenok\Account\Widget\ResetPassword\Controller@reset')->name('telenok.account.reset.finish');

