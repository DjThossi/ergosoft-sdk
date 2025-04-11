<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk;

use DjThossi\ErgosoftSdk\Api\GetJobByGuidApi;
use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Api\SubmitDeltaXmlFileApi;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;

readonly class ErgosoftFactory
{
    public function __construct(
        private string $baseUrl,
    ) {
    }

    public function getJobsApi(): GetJobsApi
    {
        return new GetJobsApi(
            $this->createClient(),
            $this->createJobMapper()
        );
    }

    public function getJobByGuidApi(): GetJobByGuidApi
    {
        return new GetJobByGuidApi(
            $this->createClient(),
            $this->createJobMapper()
        );
    }

    public function getSubmitDeltaXmlFileApi(): SubmitDeltaXmlFileApi
    {
        return new SubmitDeltaXmlFileApi(
            $this->createClient()
        );
    }

    private function createJobMapper(): JobMapper
    {
        return new JobMapper();
    }

    private function createClient(): Client
    {
        return new Client($this->baseUrl);
    }
}
