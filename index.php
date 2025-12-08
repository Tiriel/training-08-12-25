<?php

require __DIR__.'/Car.php';
require __DIR__.'/EventDispatcher.php';
require __DIR__.'/NewUserEvent.php';
require __DIR__.'/GreetNewUserListener.php';

// $car = new Car();
// $car = Car::__construct();

$dispatcher = new EventDispatcher();
$dispatcher->addListener(NewUserEvent::class, new GreetNewUserListener());

// in registration workflow
$dispatcher->dispatch(new NewUserEvent(1));
