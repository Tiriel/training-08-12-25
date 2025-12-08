<?php

class EventDispatcher
{
    /**
     * @var array<string, array<int, callable>>
     */
    private array $listeners = [];

    public function addListener(string $eventName, callable|EventListenerInterface $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(object $event, ?string $eventName = null): object
    {
        $eventName ??= $event::class;
        $calledListeners = [];
        $listenersToCall = $this->listeners[$eventName] ?? [];

        foreach ($listenersToCall as $listener) {
            if (!\in_array($listener, $calledListeners)) {
                $listener instanceof EventListenerInterface
                    ? $listener->handle($event)
                    : $listener($event);
                $calledListeners[] = $listener;
            }
        }

        return $event;
    }
}
