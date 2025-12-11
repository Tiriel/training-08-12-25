<?php

namespace App\Search;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        #[Autowire(env: 'CONF_API_KEY')]
        private string $apiKey,
    ){}

    public function searchByName(?string $name = null): array
    {
        return $this->client->request(Request::METHOD_GET, 'https://www.devevents-api.fr/events', [
            'query' => ['name' => $name],
            'headers' => [
                'apikey' => $this->apiKey,
                'Accept' => 'application/json',
            ],
        ])->toArray();
    }
}
