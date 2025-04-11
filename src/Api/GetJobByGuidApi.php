<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Exception\JobNotFoundException;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;

use const JSON_THROW_ON_ERROR;

readonly class GetJobByGuidApi
{
    public function __construct(
        private Client $client,
        private JobMapper $jobMapper,
    ) {
    }

    public function getJobByGuid(JobGuid $jobGuid): Job
    {
        $response = $this->client->get('/Trickle/get-job-by-guid/' . $jobGuid->value);
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        if (empty($data)) {
            throw new JobNotFoundException($jobGuid->value);
        }

        return $this->jobMapper->mapFromArray($data);
    }
}
