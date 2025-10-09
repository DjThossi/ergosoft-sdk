<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\Endpoint;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Domain\StringResponseBody;
use DjThossi\ErgosoftSdk\Domain\UnsubscribeJobStatusResponse;
use DjThossi\ErgosoftSdk\Http\Client;

readonly class UnsubscribeJobStatusApi
{
    private const string ENDPOINT = '/Trickle/unsubscribe-job-status/';

    public function __construct(
        private Client $client,
    ) {
    }

    public function unsubscribeJobStatus(JobGuid $jobGuid, Endpoint $endpoint): UnsubscribeJobStatusResponse
    {
        $url = self::ENDPOINT . $jobGuid->value . '?endpoint=' . urlencode($endpoint->value);
        $response = $this->client->delete($url);

        return new UnsubscribeJobStatusResponse(
            new StatusCode($response->getStatusCode()),
            new StringResponseBody((string) $response->getBody())
        );
    }
}
