<?php

class NewUserEvent
{
    public function __construct(
        public private(set) int $userId,
    ) {}
}
