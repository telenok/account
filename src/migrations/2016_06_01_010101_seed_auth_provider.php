<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedAuthProvider extends Migration {

    public function up()
    {
        // Widget group
        (new \App\Vendor\Telenok\Core\Model\Web\WidgetGroup())->storeOrUpdate([
            'title' => ['en' => 'Account', 'ru' => 'Аккаунт'],
            'active' => 1,
            'controller_class' => '\App\Vendor\Telenok\Account\WidgetGroup\Account\Controller',
        ]);

        // Widget
        (new \App\Vendor\Telenok\Core\Model\Web\Widget())->storeOrUpdate([
            'title' => ['en' => 'Login', 'ru' => 'Авторизация'],
            'active' => 1,
            'controller_class' => '\App\Vendor\Telenok\Account\Widget\Login\Controller',
        ]);

        // Widget
        (new \App\Vendor\Telenok\Core\Model\Web\Widget())->storeOrUpdate([
            'title' => ['en' => 'Reset password', 'ru' => 'Восстановление пароля'],
            'active' => 1,
            'controller_class' => '\App\Vendor\Telenok\Account\Widget\ResetPassword\Controller',
        ]);

        // Social network setting
        (new \App\Vendor\Telenok\Core\Model\System\Setting())->storeOrUpdate([
            'title' => ['en' => 'Socialite settings', 'ru' => 'Настройки социальных сетей'],
            'active' => 1,
            'code' => 'telenok.social.network',
            'value' => [
                'services.github.client_id' => "",
                'services.github.client_secret' => "",
                'services.github.enabled' => 0,

                'services.facebook.client_id' => "",
                'services.facebook.client_secret' => "",
                'services.facebook.enabled' => 0,

                'services.google.client_id' => "",
                'services.google.client_secret' => "",
                'services.google.enabled' => 0,

                'services.linkedin.client_id' => "",
                'services.linkedin.client_secret' => "",
                'services.linkedin.enabled' => 0,

                'services.twitter.client_id' => "",
                'services.twitter.client_secret' => "",
                'services.twitter.enabled' => 0,

                'services.bitbucket.client_id' => "",
                'services.bitbucket.client_secret' => "",
                'services.bitbucket.enabled' => 0,
            ],
        ]);
    }
}
