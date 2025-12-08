<?php

namespace App\EventDispatcher\Event;
class NewUserEvent extends Event
{
    public function __construct(
        public private(set) int $userId,
    ) {
    }
}
