<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\MoveUpJobPositionInQueueResponse;
use DjThossi\ErgosoftSdk\Domain\MoveUpJobPositionInQueueResponseBody;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Http\Client;

readonly class MoveUpJobPositionInQueueApi
{
    private const string ENDPOINT = '/Trickle/move-up-job-position-in-queue/';

    public function __construct(
        private Client $client,
    ) {
    }

    public function moveUp(JobGuid $jobGuidMoveUp, JobGuid $jobGuidMoveDown): MoveUpJobPositionInQueueResponse
    {
        $response = $this->client->put(self::ENDPOINT . $jobGuidMoveUp->value . '/' . $jobGuidMoveDown->value);

        return new MoveUpJobPositionInQueueResponse(
            new StatusCode($response->getStatusCode()),
            new MoveUpJobPositionInQueueResponseBody((string) $response->getBody())
        );
    }
}
