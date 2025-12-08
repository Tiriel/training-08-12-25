<?php

use App\EventDispatcher\Event\NewUserEvent;
use App\EventDispatcher\EventDispatcher;
use App\EventDispatcher\Exception\NoListenersException;
use App\EventDispatcher\Listener\GreetNewUserListener;

require_once __DIR__ . '/vendor/autoload.php';

//spl_autoload_register(function ($classname) {
//    $classname = strtr($classname, '\\', '//');
//    include_once $classname.'.php';
//});

// $car = new Car();
// $car = Car::__construct();

$dispatcher = new EventDispatcher();
$dispatcher->addListener(NewUserEvent::class, new GreetNewUserListener());

// in registration workflow
try {
    $event = $dispatcher->dispatch(new NewUserEvent(1));
    echo $event->userId.\PHP_EOL;
} catch (NoListenersException $e) {
    echo 'No listeners were called';
}
