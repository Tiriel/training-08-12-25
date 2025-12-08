<?php

class GreetNewUserListener
{
    public function sendWelcomeMail(NewUserEvent $event): void
    {
        $user = $event->userId;

        // send mail to greet user
    }
}
