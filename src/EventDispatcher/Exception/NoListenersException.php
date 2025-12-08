<?php

namespace App\EventDispatcher\Exception;
class NoListenersException extends \RuntimeException
{
    public function __construct(string $message = "No listeners were added for this event", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
