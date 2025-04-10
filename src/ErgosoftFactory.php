<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk;

use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Api\GetJobByGuidApi;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;

readonly class ErgosoftFactory
{
    public function __construct(
        private string $baseUrl,
    ) {
    }

    private function createJobMapper(): JobMapper
    {
        return new JobMapper();
    }

    public function getJobsApi(): GetJobsApi
    {
        return new GetJobsApi(
            new Client($this->baseUrl),
            $this->createJobMapper()
        );
    }

    public function getJobByGuidApi(): GetJobByGuidApi
    {
        return new GetJobByGuidApi(
            new Client($this->baseUrl),
            $this->createJobMapper()
        );
    }
}
