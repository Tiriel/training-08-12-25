<?php

namespace App\EventDispatcher\Listener;
interface EventListenerInterface
{
    public function handle(object $event): void;
}
