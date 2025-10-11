<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\GetJobByGuidResponse;
use DjThossi\ErgosoftSdk\Domain\GetJobByGuidResponseBody;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;
use GuzzleHttp\Exception\BadResponseException;

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
        try {
            $response = $this->client->get(self::ENDPOINT . $jobGuid->value);
        } catch (BadResponseException $e) {
            return new GetJobByGuidResponse(
                new StatusCode($e->getCode()),
                null,
                new GetJobByGuidResponseBody($e->getResponse()->getBody()->getContents())
            );
        }
        $responseBody = (string) $response->getBody();
        $data = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);

        if (empty($data)) {
            return new GetJobByGuidResponse(
                new StatusCode($response->getStatusCode()),
                null,
                new GetJobByGuidResponseBody($responseBody)
            );
        }

        $job = $this->jobMapper->mapFromArray($data);

        return new GetJobByGuidResponse(
            new StatusCode($response->getStatusCode()),
            $job,
            new GetJobByGuidResponseBody($responseBody)
        );
    }
}
