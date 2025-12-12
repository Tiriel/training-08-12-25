<?php

namespace App\Search;

use App\Dto\ApiConference;
use App\Search\Transformer\ApiToConferenceDtoTransformer;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AutoconfigureTag('app.conference_search')]
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
