<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\GetJobByGuidResponse;
use DjThossi\ErgosoftSdk\Domain\GetJobByGuidResponseBody;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Exception\JobNotFoundException;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;

use const JSON_THROW_ON_ERROR;

readonly class GetJobByGuidApi
{
    private const string ENDPOINT = '/Trickle/get-job-by-guid/';

    public function __construct(
        private Client $client,
        private JobMapper $jobMapper,
    ) {
    }

    public function getJobByGuid(JobGuid $jobGuid): GetJobByGuidResponse
    {
        $response = $this->client->get(self::ENDPOINT . $jobGuid->value);
        $responseBody = (string) $response->getBody();
        $data = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);

        if (empty($data)) {
            throw new JobNotFoundException($jobGuid->value);
        }

        $job = $this->jobMapper->mapFromArray($data);

        return new GetJobByGuidResponse(
            new StatusCode($response->getStatusCode()),
            $job,
            new GetJobByGuidResponseBody($responseBody)
        );
    }
}
