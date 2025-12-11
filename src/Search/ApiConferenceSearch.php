<?php

namespace App\Search;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsAlias]
class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $confClient,
    ){}

    public function searchByName(?string $name = null): array
    {
        return $this->confClient->request(Request::METHOD_GET, '/events', [
            'query' => ['name' => $name],
        ])->toArray();
    }
}
