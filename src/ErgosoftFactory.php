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
        private ErgosoftConfiguration $configuration,
    ) {
    }

    public function createGetJobsApi(): GetJobsApi
    {
        return new GetJobsApi(
            $this->createClient(),
            $this->createJobMapper()
        );
    }

    public function createGetJobByGuidApi(): GetJobByGuidApi
    {
        return new GetJobByGuidApi(
            $this->createClient(),
            $this->createJobMapper()
        );
    }

    public function createSubmitDeltaXmlFileApi(): SubmitDeltaXmlFileApi
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
        return new Client(
            $this->configuration->getBaseUrl(),
            $this->configuration->getRequestTimeout()
        );
    }
}
