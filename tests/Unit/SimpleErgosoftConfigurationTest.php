<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit;

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Domain\RequestTimeout;
use DjThossi\ErgosoftSdk\ErgosoftConfiguration;
use DjThossi\ErgosoftSdk\SimpleErgosoftConfiguration;
use PHPUnit\Framework\TestCase;

class SimpleErgosoftConfigurationTest extends TestCase
{
    public function testImplementsErgosoftConfigurationInterface(): void
    {
        $config = new SimpleErgosoftConfiguration(new BaseUrl('https://api.ergosoft.example'));
        $this->assertInstanceOf(ErgosoftConfiguration::class, $config);
    }

    public function testReturnsGivenBaseUrl(): void
    {
        $baseUrl = new BaseUrl('https://api.ergosoft.example/');
        $config = new SimpleErgosoftConfiguration($baseUrl);

        $this->assertSame($baseUrl, $config->getBaseUrl());
        $this->assertSame('https://api.ergosoft.example', $config->getBaseUrl()->value);
    }

    public function testUsesDefaultRequestTimeoutWhenNotProvided(): void
    {
        $config = new SimpleErgosoftConfiguration(new BaseUrl('https://api.ergosoft.example'));
        $timeout = $config->getRequestTimeout();

        $this->assertInstanceOf(RequestTimeout::class, $timeout);
        $this->assertSame(10.0, $timeout->seconds);
    }

    public function testUsesProvidedRequestTimeout(): void
    {
        $timeout = new RequestTimeout(3.5);
        $config = new SimpleErgosoftConfiguration(new BaseUrl('https://api.ergosoft.example'), $timeout);

        $this->assertSame($timeout, $config->getRequestTimeout());
        $this->assertSame(3.5, $config->getRequestTimeout()->seconds);
    }
}
