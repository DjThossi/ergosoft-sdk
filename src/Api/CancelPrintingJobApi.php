<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Http\Client;

readonly class CancelPrintingJobApi
{
    private const string ENDPOINT = '/Trickle/cancel-printing-job/';

    public function __construct(
        private Client $client,
    ) {
    }

    public function cancelPrintingJob(JobGuid $jobGuid): StatusCode
    {
        $response = $this->client->put(self::ENDPOINT . $jobGuid->value);

        return new StatusCode($response->getStatusCode());
    }
}
