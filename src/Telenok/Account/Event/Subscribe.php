<?php namespace Telenok\Account\Event;

use \Telenok\Core\Event\RepositoryPackage;
use \Telenok\Core\Event\Config;

class Subscribe {

    public function onRepositoryPackage(RepositoryPackage $event)
    {
        $event->getList()->push('Telenok\Account\PackageInfo');
    }

    public function onUserLogin(\Illuminate\Auth\Events\Login $event)
    {
        session(['telenok.user.logined' => true]);
    }

    public function subscribe($events)
    {
        $this->addListenerRepositoryPackage($events);
        $this->addListenerLogin($events);
    }

    public function addListenerRepositoryPackage($events)
    {
        $events->listen(
            'Telenok\Core\Event\RepositoryPackage',
            'App\Vendor\Telenok\Account\Event\Subscribe@onRepositoryPackage'
        );
    }

    public function addListenerLogin($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Vendor\Telenok\Account\Event\Subscribe@onUserLogin'
        );
    }
}
