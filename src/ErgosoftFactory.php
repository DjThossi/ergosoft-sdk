<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk;

use DjThossi\ErgosoftSdk\Api\CancelPrintingJobApi;
use DjThossi\ErgosoftSdk\Api\CancelRippingJobApi;
use DjThossi\ErgosoftSdk\Api\DeleteJobApi;
use DjThossi\ErgosoftSdk\Api\GetJobByGuidApi;
use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Api\SubscribeJobStatusApi;
use DjThossi\ErgosoftSdk\Api\SubmitDeltaXmlFileApi;
use DjThossi\ErgosoftSdk\Api\TestCommunicationsApi;
use DjThossi\ErgosoftSdk\Api\UnsubscribeJobStatusApi;
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

    public function createDeleteJobApi(): DeleteJobApi
    {
        return new DeleteJobApi(
            $this->createClient()
        );
    }

    public function createCancelRippingJobApi(): CancelRippingJobApi
    {
        return new CancelRippingJobApi(
            $this->createClient()
        );
    }

    public function createCancelPrintingJobApi(): CancelPrintingJobApi
    {
        return new CancelPrintingJobApi(
            $this->createClient()
        );
    }

    public function createSubscribeJobStatusApi(): SubscribeJobStatusApi
    {
        return new SubscribeJobStatusApi(
            $this->createClient()
        );
    }

    public function createUnsubscribeJobStatusApi(): UnsubscribeJobStatusApi
    {
        return new UnsubscribeJobStatusApi(
            $this->createClient()
        );
    }

    public function createTestCommunicationsApi(): TestCommunicationsApi
    {
        return new TestCommunicationsApi(
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
