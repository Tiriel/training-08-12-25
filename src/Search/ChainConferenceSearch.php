<?php

namespace App\Search;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;

#[AsAlias]
class ChainConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        #[AutowireLocator('app.conference_search')]
        private readonly ContainerInterface $searches,
    ) {}

    public function searchByName(?string $name = null, int $page = 1): array
    {
        $conferences = $this->searches->get(DatabaseConferenceSearch::class)->searchByName($name, $page);

        if ([] === $conferences) {
            return $this->searches->get(ApiConferenceSearch::class)->searchByName($name);
        }

        return $conferences;
    }
}
