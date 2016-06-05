<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedAuthProvider extends Migration {

    public function up()
    {
        // Widget group
        (new \App\Telenok\Core\Model\Web\WidgetGroup())->storeOrUpdate([
            'title' => ['en' => 'Account', 'ru' => 'Аккаунт'],
            'active' => 1,
            'controller_class' => '\App\Telenok\Account\WidgetGroup\Account\Controller',
        ]);

        // Widget
        (new \App\Telenok\Core\Model\Web\Widget())->storeOrUpdate([
            'title' => ['en' => 'Login', 'ru' => 'Авторизация'],
            'active' => 1,
            'controller_class' => '\App\Telenok\Account\Widget\Login\Controller',
        ]);
    }
}
