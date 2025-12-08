<?php

namespace App\EventDispatcher\Event;

class Event
{
    private bool $propagationStopped = false;

    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }
}
