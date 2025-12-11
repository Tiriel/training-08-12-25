<?php

namespace App\Search;

use App\Search\ConferenceSearchInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\String\Slugger\SluggerInterface;

#[When('dev')]
#[AsDecorator(ConferenceSearchInterface::class, priority: 5)]
class TraceableConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        private readonly ConferenceSearchInterface $inner,
        private readonly LoggerInterface $logger,
        private readonly SluggerInterface $slugger,
    ) {}

    public function searchByName(?string $name = null): array
    {
        $slug = $this->slugger->slug($name);
        $this->logger->info("Searching for conference", ['slug' => $slug]);

        return $this->inner->searchByName($name);
    }
}
