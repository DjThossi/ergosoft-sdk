<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Http\Client;

readonly class DeleteJobApi
{
    private const string ENDPOINT = '/Trickle/delete-job/';

    public function __construct(
        private Client $client,
    ) {
    }

    public function deleteJob(JobGuid $jobGuid): StatusCode
    {
        $response = $this->client->delete(self::ENDPOINT . $jobGuid->value);

        return new StatusCode($response->getStatusCode());
    }
}
