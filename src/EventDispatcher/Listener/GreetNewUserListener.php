<?php

namespace App\EventDispatcher\Listener;

class GreetNewUserListener implements EventListenerInterface
{
    public function handle(object $event): void
    {
        $user = $event->userId;

        // send mail to greet user
    }
}
