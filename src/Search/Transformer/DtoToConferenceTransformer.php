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
        'creationDate',
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
            $org = $this->organizationRepository->findOneBy([
                    'name' => $arrayOrg['name'],
                    'createdAt' => $arrayOrg['creationDate'],
                ])
                ?? $this->createOrg($arrayOrg);

            $conference->addOrganization($org);
        }

        return $conference;
    }

    private function createOrg(array $arrayOrg): Organization
    {
        if (0 < \count(\array_diff(self::ORG_KEYS, \array_keys($arrayOrg)))) {
            throw new MissingKeyFromApiException();
        }

        return (new Organization())
            ->setName($arrayOrg['name'])
            ->setPresentation($arrayOrg['presentation'])
            ->setCreatedAt($arrayOrg['creationDate']);
    }
}
