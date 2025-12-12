<?php

namespace App\Event;

use App\Dto\ApiConference;
use Symfony\Contracts\EventDispatcher\Event;

class ApiConferencesReceivedEvent extends Event
{
    public function __construct(
        /** @var ApiConference[] $conferences */
        private array $conferences,
    ) {}

    public function getConferences(): array
    {
        return $this->conferences;
    }

    public function setConferences(array $conferences): ApiConferencesReceivedEvent
    {
        $this->conferences = $conferences;

        return $this;
    }
}
