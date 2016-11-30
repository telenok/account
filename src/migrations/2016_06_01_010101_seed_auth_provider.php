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



        $configGroupAccount = (new \App\Vendor\Telenok\Core\Model\System\ConfigGroup())->storeOrUpdate([
            'title' => ['en' => 'Account', 'ru' => 'Аккаунт'],
            'active' => 1,
            'code' => 'account',
        ]);

        // Github
        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Github client ID', 'ru' => 'Github client ID'],
            'active' => 1,
            'code' => 'services.github.client_id',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Github client secret', 'ru' => 'Github client secret'],
            'active' => 1,
            'code' => 'services.github.client_secret',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Github client enabled', 'ru' => 'Github client активен'],
            'active' => 1,
            'code' => 'services.github.enabled',
            'value' => 0,
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        // Facebook
        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Facebook client ID', 'ru' => 'Facebook client ID'],
            'active' => 1,
            'code' => 'services.facebook.client_id',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Facebook client secret', 'ru' => 'Facebook client secret'],
            'active' => 1,
            'code' => 'services.facebook.client_secret',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Facebook client enabled', 'ru' => 'Facebook client активен'],
            'active' => 1,
            'code' => 'services.facebook.enabled',
            'value' => 0,
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        // Google
        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Google client ID', 'ru' => 'Google client ID'],
            'active' => 1,
            'code' => 'services.google.client_id',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Google client secret', 'ru' => 'Google client secret'],
            'active' => 1,
            'code' => 'services.google.client_secret',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Google client enabled', 'ru' => 'Google client активен'],
            'active' => 1,
            'code' => 'services.google.enabled',
            'value' => 0,
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        // Linkedin
        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Linkedin client ID', 'ru' => 'Linkedin client ID'],
            'active' => 1,
            'code' => 'services.linkedin.client_id',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Linkedin client secret', 'ru' => 'Linkedin client secret'],
            'active' => 1,
            'code' => 'services.linkedin.client_secret',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Linkedin client enabled', 'ru' => 'Linkedin client активен'],
            'active' => 1,
            'code' => 'services.linkedin.enabled',
            'value' => 0,
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        // Twitter
        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Twitter client ID', 'ru' => 'Twitter client ID'],
            'active' => 1,
            'code' => 'services.twitter.client_id',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Twitter client secret', 'ru' => 'Twitter client secret'],
            'active' => 1,
            'code' => 'services.twitter.client_secret',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Twitter client enabled', 'ru' => 'Twitter client активен'],
            'active' => 1,
            'code' => 'services.twitter.enabled',
            'value' => 0,
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        // Bitbucket
        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Bitbucket client ID', 'ru' => 'Bitbucket client ID'],
            'active' => 1,
            'code' => 'services.bitbucket.client_id',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Bitbucket client secret', 'ru' => 'Bitbucket client secret'],
            'active' => 1,
            'code' => 'services.bitbucket.client_secret',
            'value' => '',
            'config_config_group' => $configGroupAccount->getKey(),
        ]);

        (new \App\Vendor\Telenok\Core\Model\System\Config())->storeOrUpdate([
            'title' => ['en' => 'Bitbucket client enabled', 'ru' => 'Bitbucket client активен'],
            'active' => 1,
            'code' => 'services.bitbucket.enabled',
            'value' => 0,
            'config_config_group' => $configGroupAccount->getKey(),
        ]);
    }
}
