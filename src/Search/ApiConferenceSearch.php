<?php

namespace App\Search;

use App\Search\ConferenceSearchInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        #[Autowire(env: 'CONF_API_KEY')]
        private string $apiKey,
    ){}

    public function searchByName(?string $name = null): array
    {
        // TODO: Implement searchByName() method.
    }
}
