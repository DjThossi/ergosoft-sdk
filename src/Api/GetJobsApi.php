<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\JobCollection;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;

use function is_array;

use const JSON_THROW_ON_ERROR;

readonly class GetJobsApi
{
    private const string ENDPOINT = '/Trickle/get-jobs';

    public function __construct(
        private Client $client,
        private JobMapper $jobMapper,
    ) {
    }

    public function getJobs(): JobCollection
    {
        $response = $this->client->get(self::ENDPOINT);
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $jobs = new JobCollection();
        if (is_array($data)) {
            foreach ($data as $jobData) {
                $jobs->add($this->jobMapper->mapFromArray($jobData));
            }
        }

        return $jobs;
    }
}
