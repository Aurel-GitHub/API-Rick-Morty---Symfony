<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getAllCharacters(): array
    {
        $response = $this->client->request(
            'GET',
            'https://rickandmortyapi.com/api/character'
        );

        return $response->toArray();
    }

    public function getAllLocations(): array
    {
        $response = $this->client->request(
            'GET',
            'https://rickandmortyapi.com/api/location'
        );

        return $response->toArray();
    }
    
    public function getAllEpisodes(): array
    {
        $response = $this->client->request(
            'GET',
            'https://rickandmortyapi.com/api/episode'
        );

        return $response->toArray();
    }
}