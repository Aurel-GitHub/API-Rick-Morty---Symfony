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
        return $this->getApi('character');
    }

    public function getCharacterById($id): array
    {
        return $this->getApi('character/'. $id);
    }

    private function getApi(string $var)
    {
        $response = $this->client->request(
            'GET',
            'https://rickandmortyapi.com/api/' . $var
        );

        return $response->toArray();
    }

    
}