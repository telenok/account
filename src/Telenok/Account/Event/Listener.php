<?php namespace Telenok\Account\Event;

use \Telenok\Core\Event\RepositoryPackage;
use \Telenok\Core\Event\RepositorySetting;

class Listener {

    public function onRepositoryPackage(RepositoryPackage $event)
    {
        $event->getList()->push('Telenok\Account\PackageInfo');
    }

    public function onRepositorySetting(RepositorySetting $event)
    {
        $event->getList()->push('App\Telenok\Account\Setting\SocialNetwork\Controller');
    }

    public function subscribe($events)
    {
        $this->addListenerRepositoryPackage($events);
        $this->addListenerRepositorySetting($events);
    }

    public function addListenerRepositoryPackage($events)
    {
        $events->listen(
            'App\Telenok\Core\Event\RepositoryPackage',
            'App\Telenok\Account\Event\Listener@onRepositoryPackage'
        );
    }

    public function addListenerRepositorySetting($events)
    {
        $events->listen(
            'App\Telenok\Core\Event\RepositorySetting',
            'App\Telenok\Account\Event\Listener@onRepositorySetting'
        );
    }
}
