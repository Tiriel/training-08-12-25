<?php

namespace App\Search\Transformer;

use App\Dto\ApiConference;
use App\Entity\Conference;
use App\Entity\Organization;
use App\Exception\MissingKeyFromApiException;
use App\Repository\OrganizationRepository;
use App\Search\Transformer\TransformerInterface;

class DtoToConferenceTransformer extends AbstractDataTransformer
{
    private const ORG_KEYS = [
        'name',
        'presentation',
    ];

    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
    ) {}

    public function transformOne(mixed $data): mixed
    {
        if (!$data instanceof ApiConference) {
            throw new \InvalidArgumentException('$data must be an instance of '. ApiConference::class);
        }

        $conference = (new Conference())
            ->setName($data->getName())
            ->setDescription($data->getDescription())
            ->setAccessible($data->isAccessible())
            ->setPrerequisites($data->getPrerequisites())
            ->setStartAt($data->getStartAt())
            ->setEndAt($data->getEndAt());

        foreach ($data->getOrganizations() as $arrayOrg) {
            $conference->addOrganization($this->getOrCreateOrg($arrayOrg));
        }

        return $conference;
    }

    private function getOrCreateOrg(array $arrayOrg): Organization
    {
        dump($arrayOrg);
        if (0 < \count(\array_diff(self::ORG_KEYS, \array_keys($arrayOrg)))) {
            throw new MissingKeyFromApiException();
        }

        $org = $this->organizationRepository->findOneBy(['name' => $arrayOrg['name']]);

        if (null === $org) {
            return (new Organization())
                ->setName($arrayOrg['name'])
                ->setPresentation($arrayOrg['presentation'])
                ->setCreatedAt(new \DateTimeImmutable($arrayOrg['creationDate'] ?? null));
        }

        return $org;
    }
}
