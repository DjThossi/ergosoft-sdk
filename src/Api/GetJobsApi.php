<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;

readonly class GetJobsApi
{
    private const string ENDPOINT = '/Trickle/get-jobs';

    public function __construct(
        private Client $client,
        private JobMapper $jobMapper,
    ) {
    }

    /**
     * @return Job[]
     */
    public function getJobs(): array
    {
        $response = $this->client->get(self::ENDPOINT);
        $data = json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);

        $jobs = [];
        if (\is_array($data)) {
            foreach ($data as $jobData) {
                $jobs[] = $this->jobMapper->mapFromArray($jobData);
            }
        }

        return $jobs;
    }
}
