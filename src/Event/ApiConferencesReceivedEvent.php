<?php

namespace App\Event;

use App\Dto\ApiConference;
use Symfony\Contracts\EventDispatcher\Event;

class ApiConferencesReceivedEvent extends Event
{
    public function __construct(
        /** @var ApiConference[] $conferences */
        public readonly array $conferences,
    ) {}
}
