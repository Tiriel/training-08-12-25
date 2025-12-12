<?php

namespace App\Search;

use App\Event\ApiConferencesReceivedEvent;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsAlias]
class ChainConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        #[AutowireLocator('app.conference_search')]
        private readonly ContainerInterface $searches,
        private readonly EventDispatcherInterface $dispatcher,
    ) {}

    public function searchByName(?string $name = null, int $page = 1): array
    {
        $conferences = $this->searches->get(DatabaseConferenceSearch::class)->searchByName($name, $page);

        if ([] === $conferences) {
            $conferences = $this->searches->get(ApiConferenceSearch::class)->searchByName($name);

            $this->dispatcher->dispatch(new ApiConferencesReceivedEvent($conferences));

            return $conferences;
        }

        return $conferences;
    }
}
