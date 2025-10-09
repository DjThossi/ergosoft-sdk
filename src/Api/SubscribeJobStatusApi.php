<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\Endpoint;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Domain\StringResponseBody;
use DjThossi\ErgosoftSdk\Domain\SubscribeJobStatusResponse;
use DjThossi\ErgosoftSdk\Http\Client;

use const JSON_THROW_ON_ERROR;

readonly class SubscribeJobStatusApi
{
    private const string ENDPOINT = '/Trickle/subscribe-job-status';

    public function __construct(
        private Client $client,
    ) {
    }

    public function subscribeJobStatus(JobGuid $jobGuid, Endpoint $endpoint): SubscribeJobStatusResponse
    {
        $jsonContent = json_encode([
            'jobGuid' => $jobGuid->value,
            'endpoint' => $endpoint->value,
        ], JSON_THROW_ON_ERROR);

        $response = $this->client->post(self::ENDPOINT, $jsonContent);

        return new SubscribeJobStatusResponse(
            new StatusCode($response->getStatusCode()),
            new StringResponseBody((string) $response->getBody())
        );
    }
}
