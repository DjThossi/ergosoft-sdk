<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Domain\TestCommunicationsResponse;
use DjThossi\ErgosoftSdk\Domain\TestCommunicationsResponseBody;
use DjThossi\ErgosoftSdk\Http\Client;

readonly class TestCommunicationsApi
{
    private const string ENDPOINT = '/Trickle/test-communications';

    public function __construct(
        private Client $client,
    ) {
    }

    public function testCommunications(): TestCommunicationsResponse
    {
        $response = $this->client->get(self::ENDPOINT);

        return new TestCommunicationsResponse(
            new StatusCode($response->getStatusCode()),
            new TestCommunicationsResponseBody((string) $response->getBody())
        );
    }
}
