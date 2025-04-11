<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Http;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private GuzzleClient $client;
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->client = new GuzzleClient([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function get(string $endpoint): ResponseInterface
    {
        return $this->client->get($this->baseUrl . '/' . ltrim($endpoint, '/'));
    }

    public function post(string $endpoint, string $body): ResponseInterface
    {
        return $this->client->post($this->baseUrl . '/' . ltrim($endpoint, '/'), [
            'body' => $body,
        ]);
    }
}
