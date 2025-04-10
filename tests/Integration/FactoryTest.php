<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Integration;

use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Factory\ErgosoftFactory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testGetJobsApi(): void
    {
        $factory = new ErgosoftFactory('https://api.ergosoft.de');
        $this->assertInstanceOf(GetJobsApi::class, $factory->getJobsApi());
    }
}
