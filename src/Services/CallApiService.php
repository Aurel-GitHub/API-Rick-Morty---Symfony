<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    const CHARACTER = "character";
    const LOCATION = 'location';
    const EPISODE = 'episode';

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    private function getApi(string $var)
    {
        $response = $this->client->request('GET', 'https://rickandmortyapi.com/api/' . $var);
        return $response->toArray();
    }

    public function getResultByPage(string $type, $page = 1): array
    {
        return $this->getApi($type. '/?page=' . $page);
    }

    public function getResultById(string $type, int $id): array
    {
        return $this->getApi($type .'/'. $id);
    }

}