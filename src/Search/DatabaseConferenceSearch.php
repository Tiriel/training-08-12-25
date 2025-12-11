<?php

namespace App\Search;

use App\Repository\ConferenceRepository;

readonly class DatabaseConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        private ConferenceRepository $repository,
    ) {
    }

    public function searchByName(?string $name = null, int $page = 1): array
    {
        if (\is_string($name)) {
            return $this->repository->findLikeName($name, $page);
        }

        return $this->repository->findBy([], [], ConferenceRepository::MAX_RESULTS, ConferenceRepository::MAX_RESULTS * ($page - 1));
    }
}
