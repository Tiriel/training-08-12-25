<?php

namespace App\Search\Persister;

use App\Dto\ApiConference;
use App\Repository\ConferenceRepository;
use App\Search\Transformer\ApiToConferenceDtoTransformer;
use Doctrine\ORM\EntityManagerInterface;

class ApiConferencePersister
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly ConferenceRepository $repository,
        private readonly ApiToConferenceDtoTransformer $transformer,
    ) {}

    /**
     * @param ApiConference[] $apiConferences
     */
    public function persistConferences(array $apiConferences): void
    {
        foreach ($apiConferences as $apiConference) {
            $conference = $this->repository->findOneBy([
                'name' => $apiConference->getName(),
                'startAt' => $apiConference->getStartAt(),
                'endAt' => $apiConference->getEndAt(),
            ]);

            if (null === $conference) {
                $conference = $this->transformer->transformOne($apiConference);
                $this->manager->persist($conference);
            }
        }

        $this->manager->flush();
    }
}
