<?php

namespace App\Dto;

class ApiConference
{
    private string $name;
    private string $description;
    private bool $accessible;
    private string $prerequisites;
    private \DateTimeInterface $startAt;
    private \DateTimeInterface $endAt;
    private array $organizations;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ApiConference
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): ApiConference
    {
        $this->description = $description;
        return $this;
    }

    public function isAccessible(): bool
    {
        return $this->accessible;
    }

    public function setAccessible(bool $accessible): ApiConference
    {
        $this->accessible = $accessible;
        return $this;
    }

    public function getPrerequisites(): string
    {
        return $this->prerequisites;
    }

    public function setPrerequisites(string $prerequisites): ApiConference
    {
        $this->prerequisites = $prerequisites;
        return $this;
    }

    public function getStartAt(): \DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): ApiConference
    {
        $this->startAt = $startAt;
        return $this;
    }

    public function getEndAt(): \DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): ApiConference
    {
        $this->endAt = $endAt;
        return $this;
    }

    public function getOrganizations(): array
    {
        return $this->organizations;
    }

    public function setOrganizations(array $organizations): ApiConference
    {
        $this->organizations = $organizations;
        return $this;
    }

    public static function create(array $conference): ApiConference
    {
        return (new static())
            ->setName($conference['name'])
            ->setDescription($conference['description'])
            ->setAccessible($conference['accessible'])
            ->setPrerequisites($conference['prerequisites'])
            ->setStartAt(\DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $conference['startDate']))
            ->setEndAt(\DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $conference['endDate']))
            ->setOrganizations($conference['organizations']);
    }
}
