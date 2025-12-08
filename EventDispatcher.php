<?php

class EventDispatcher
{
    /**
     * @var array<string, array<int, callable>>
     */
    private array $listeners = [];

    public function addListener(string $eventName, callable $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(object $event, ?string $eventName = null): object
    {
        $calledListeners = [];

        if (\is_string($eventName) && '' !== $eventName) {
            $listenersToCall = $this->listeners[$eventName] ?? [];
        } else {
            $listenersToCall = $this->listeners[$event::class];
        }

        foreach ($listenersToCall as $listener) {
            if (!\in_array($listener, $calledListeners)) {
                $listener($event);
                $calledListeners[] = $listener;
            }
        }

        return $event;
    }
}
