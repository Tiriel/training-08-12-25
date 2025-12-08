<?php

namespace App\EventDispatcher;

use App\EventDispatcher\Event\Event;
use App\EventDispatcher\Exception\NoListenersException;
use App\EventDispatcher\Listener\EventListenerInterface;

class EventDispatcher
{
    /**
     * @var array<string, array<int, callable>>
     */
    private array $listeners = [];

    private array $calledListeners = [];

    public function addListener(string $eventName, callable|EventListenerInterface $listener, int $priority = 0): void
    {
        $this->listeners[$eventName][$priority][] = $listener;
    }

    public function dispatch(object $event, ?string $eventName = null): object
    {
        $eventName ??= $event::class;
        $listenersToCall = $this->listeners[$eventName] ?? [];

        if ([] === $listenersToCall) {
            throw new NoListenersException(sprintf("No listeners were added for the event %s", $eventName));
        }

        krsort($listenersToCall);

        foreach ($listenersToCall as $sortedListeners) {
            foreach ($sortedListeners as $listener) {
                $this->doDispatch($listener, $eventName, $event);
            }
        }

        $this->calledListeners = [];

        return $event;
    }

    private function doDispatch(callable|EventListenerInterface $listener, string $eventName, object $event): void
    {
        if ($event instanceof Event && $event->isPropagationStopped()) {
            return;
        }

        if (!\in_array($listener, $this->calledListeners)) {
            $listener instanceof EventListenerInterface
                ? $listener->handle($event)
                : $listener($event);
            $this->calledListeners[] = $listener;
        }
    }
}
