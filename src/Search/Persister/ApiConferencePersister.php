<?php

namespace App\Search\Persister;

use App\Dto\ApiConference;
use App\Repository\ConferenceRepository;
use App\Search\Transformer\ApiToConferenceDtoTransformer;
use App\Search\Transformer\DtoToConferenceTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ApiConferencePersister
{
    private bool $isOrgOrWebsite = false;

    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly ConferenceRepository $repository,
        private readonly DtoToConferenceTransformer $transformer,
        AuthorizationCheckerInterface $checker,
    ) {
        $this->isOrgOrWebsite = $checker->isGranted('ROLE_ORGANIZER') || $checker->isGranted('ROLE_WEBSITE');
    }

    /**
     * @param ApiConference[] $apiConferences
     */
    public function persistConferences(array $apiConferences): array
    {
        $conferences = [];
        foreach ($apiConferences as $apiConference) {
            $conference = $this->repository->findOneBy([
                'name' => $apiConference->getName(),
                'startAt' => $apiConference->getStartAt(),
                'endAt' => $apiConference->getEndAt(),
            ]);

            if (null === $conference) {
                $conference = $this->transformer->transformOne($apiConference);
                if ($this->isOrgOrWebsite) {
                    $this->manager->persist($conference);
                }
            }

            $conferences[] = $conference;
        }

        if ($this->isOrgOrWebsite) {
            $this->manager->flush();
        }

        return $conferences;
    }
}
