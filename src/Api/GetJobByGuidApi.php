<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Exception\JobNotFoundException;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;
use GuzzleHttp\Exception\GuzzleException;

readonly class GetJobByGuidApi
{
    public function __construct(
        private Client $client,
        private JobMapper $jobMapper,
    ) {
    }

    /**
     * Retrieves a job by its GUID.
     *
     * @param string $jobGuid The GUID of the job to retrieve
     *
     * @throws GuzzleException When the API request fails
     * @throws JobNotFoundException When the job is not found
     * @throws \JsonException When the response is not valid
     *
     * @return Job The job object
     */
    public function getJobByGuid(string $jobGuid): Job
    {
        $response = $this->client->get('/Trickle/get-job-by-guid/' . $jobGuid);
        $data = json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);

        if (empty($data)) {
            throw new JobNotFoundException($jobGuid);
        }

        return $this->jobMapper->mapFromArray($data);
    }
}
