<?php

namespace App\Search\Transformer;

use App\Dto\ApiConference;
use App\Exception\MissingKeyFromApiException;

class ApiToConferenceDtoTransformer
{
    private const KEYS = [
        'name',
        'description',
        'accessible',
        'prerequisites',
        'startDate',
        'endDate',
        'organizations',
    ];

    public function transformCollection(array $data): array
    {
        $conferences = [];

        foreach ($data as $datum) {
            $conferences[] = $this->transformOne($datum);
        }

        return $conferences;
    }

    public function transformOne(array $data): ApiConference
    {
        if (0 < \count(\array_diff(self::KEYS, \array_keys($data)))) {
            throw new MissingKeyFromApiException();
        }

        return (new ApiConference())
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setAccessible($data['accessible'])
            ->setPrerequisites($data['prerequisites'])
            ->setStartAt(\DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $data['startDate']))
            ->setEndAt(\DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $data['endDate']))
            ->setOrganizations($data['organizations']);
    }
}
