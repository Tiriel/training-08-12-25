<?php

namespace App\Search;

use App\Repository\ConferenceRepository;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias]
readonly class DatabaseConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        private ConferenceRepository $repository,
        private int $maxResults,
    ) {
    }

    public function searchByName(?string $name = null, int $page = 1): array
    {
        if (\is_string($name)) {
            return $this->repository->findLikeName($name, $page);
        }

        return $this->repository->findBy([], [], $this->maxResults, $this->maxResults * ($page - 1));
    }
}
