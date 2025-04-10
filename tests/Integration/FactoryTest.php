<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Integration;

use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Api\GetJobByGuidApi;
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testGetJobsApi(): void
    {
        $factory = new ErgosoftFactory('https://api.ergosoft.de');

        /** @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(GetJobsApi::class, $factory->getJobsApi());
    }

    public function testGetJobByGuidApi(): void
    {
        $factory = new ErgosoftFactory('https://api.ergosoft.de');

        /** @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(GetJobByGuidApi::class, $factory->getJobByGuidApi());
    }
}
