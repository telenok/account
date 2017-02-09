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
    }
}
