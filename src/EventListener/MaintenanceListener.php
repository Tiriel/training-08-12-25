<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

#[AsEventListener(priority: 9999)]
final class MaintenanceListener
{
    public function __construct(
        #[Autowire(env: 'APP_MAINTENANCE')]
        private readonly bool $isMaintenance,
        private readonly Environment $twig,
    ) {}

    public function __invoke(RequestEvent $event): void
    {
        if ($event->isMainRequest() && $this->isMaintenance) {
            $event->setResponse(
                new Response($this->twig->render('maintenance.html.twig'), 500)
            );
        }
    }
}
