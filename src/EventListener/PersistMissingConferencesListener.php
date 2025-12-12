<?php

namespace App\EventListener;

use App\Event\ApiConferencesReceivedEvent;
use App\Search\Persister\ApiConferencePersister;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class PersistMissingConferencesListener
{
    public function __construct(
        private readonly ApiConferencePersister $persister,
    ) {}

    #[AsEventListener]
    public function onApiConferencesReceivedEvent(ApiConferencesReceivedEvent $event): void
    {
        $conferences = $event->getConferences();
        $event->setConferences($this->persister->persistConferences($conferences));
    }
}
