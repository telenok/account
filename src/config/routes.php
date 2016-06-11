<?php

// Login
app('router')->post('personal/account/login', array('as' => 'telenok.account.login', 'uses' => 'App\Telenok\Account\Widget\Login\Controller@postLogin'));
