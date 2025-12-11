<?php

namespace App\Search;

use App\Dto\ApiConference;
use App\Search\Transformer\ApiToConferenceDtoTransformer;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsAlias]
class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $confClient,
        private readonly ApiToConferenceDtoTransformer $transformer,
    ){}

    public function searchByName(?string $name = null): array
    {
        $data = $this->confClient->request(Request::METHOD_GET, '/events', [
            'query' => ['name' => $name],
        ])->toArray();

        return $this->transformer->transformCollection($data);
    }
}
