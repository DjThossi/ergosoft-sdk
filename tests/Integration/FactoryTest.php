<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Integration;

use DjThossi\ErgosoftSdk\Api\GetJobByGuidApi;
use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Api\SubmitDeltaXmlFileApi;
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testCreateGetJobsApi(): void
    {
        $factory = new ErgosoftFactory('https://api.ergosoft.de');

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(GetJobsApi::class, $factory->createGetJobsApi());
    }

    public function testCreateGetJobByGuidApi(): void
    {
        $factory = new ErgosoftFactory('https://api.ergosoft.de');

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(GetJobByGuidApi::class, $factory->createGetJobByGuidApi());
    }

    public function testCreateSubmitDeltaXmlFileApi(): void
    {
        $factory = new ErgosoftFactory('https://api.ergosoft.de');

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(SubmitDeltaXmlFileApi::class, $factory->createSubmitDeltaXmlFileApi());
    }
}
