<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Integration;

use DjThossi\ErgosoftSdk\Api\DeleteJobApi;
use DjThossi\ErgosoftSdk\Api\GetJobByGuidApi;
use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Api\SubmitDeltaXmlFileApi;
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

    private function createErgosoftFactory(): ErgosoftFactory
    {
        $configuration = new SimpleErgosoftConfiguration(
            baseUrl: new BaseUrl('https://api.ergosoft.de'),
        );

        return new ErgosoftFactory($configuration);
    }
}
