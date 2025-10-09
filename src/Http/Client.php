<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Http;

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Domain\RequestTimeout;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private GuzzleClient $client;
    private string $baseUrl;

    public function __construct(BaseUrl $baseUrl, RequestTimeout $requestTimeout)
    {
        $this->baseUrl = $baseUrl->value;
        $this->client = new GuzzleClient([
            'timeout' => $requestTimeout->seconds,
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

    public function put(string $endpoint): ResponseInterface
    {
        return $this->client->put($this->baseUrl . '/' . ltrim($endpoint, '/'));
    }

    public function delete(string $endpoint): ResponseInterface
    {
        return $this->client->delete($this->baseUrl . '/' . ltrim($endpoint, '/'));
    }
}
