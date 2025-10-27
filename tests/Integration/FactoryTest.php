<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Integration;

use DjThossi\ErgosoftSdk\Api\CancelPrintingJobApi;
use DjThossi\ErgosoftSdk\Api\CancelRippingJobApi;
use DjThossi\ErgosoftSdk\Api\DeleteJobApi;
use DjThossi\ErgosoftSdk\Api\GetJobByGuidApi;
use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Api\MoveUpJobPositionInQueueApi;
use DjThossi\ErgosoftSdk\Api\SubmitDeltaXmlFileApi;
use DjThossi\ErgosoftSdk\Api\SubscribeJobStatusApi;
use DjThossi\ErgosoftSdk\Api\TestCommunicationsApi;
use DjThossi\ErgosoftSdk\Api\UnsubscribeJobStatusApi;
use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use DjThossi\ErgosoftSdk\SimpleErgosoftConfiguration;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testCreateGetJobsApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(GetJobsApi::class, $factory->createGetJobsApi());
    }

    public function testCreateGetJobByGuidApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(GetJobByGuidApi::class, $factory->createGetJobByGuidApi());
    }

    public function testCreateSubmitDeltaXmlFileApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(SubmitDeltaXmlFileApi::class, $factory->createSubmitDeltaXmlFileApi());
    }

    public function testCreateDeleteJobApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(DeleteJobApi::class, $factory->createDeleteJobApi());
    }

    public function testCreateCancelRippingJobApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(CancelRippingJobApi::class, $factory->createCancelRippingJobApi());
    }

    public function testCreateCancelPrintingJobApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(CancelPrintingJobApi::class, $factory->createCancelPrintingJobApi());
    }

    public function testCreateSubscribeJobStatusApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(SubscribeJobStatusApi::class, $factory->createSubscribeJobStatusApi());
    }

    public function testCreateUnsubscribeJobStatusApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(UnsubscribeJobStatusApi::class, $factory->createUnsubscribeJobStatusApi());
    }

    public function testCreateTestCommunicationsApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(TestCommunicationsApi::class, $factory->createTestCommunicationsApi());
    }

    public function testCreateMoveUpJobPositionInQueueApi(): void
    {
        $factory = $this->createErgosoftFactory();

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(MoveUpJobPositionInQueueApi::class, $factory->createMoveUpJobPositionInQueueApi());
    }

    private function createErgosoftFactory(): ErgosoftFactory
    {
        $configuration = new SimpleErgosoftConfiguration(
            baseUrl: new BaseUrl('https://api.ergosoft.de'),
        );

        return new ErgosoftFactory($configuration);
    }
}
