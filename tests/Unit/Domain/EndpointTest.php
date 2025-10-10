<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\Endpoint;
use DjThossi\ErgosoftSdk\Exception\InvalidEndpointException;
use PHPUnit\Framework\TestCase;

class EndpointTest extends TestCase
{
    public function testConstructorWithValidUrl(): void
    {
        $endpoint = new Endpoint('https://example.com/webhook');
        $this->assertEquals('https://example.com/webhook', $endpoint->value);
    }

    public function testConstructorWithValidUrlWithPort(): void
    {
        $endpoint = new Endpoint('https://example.com:8080/webhook');
        $this->assertEquals('https://example.com:8080/webhook', $endpoint->value);
    }

    public function testConstructorWithValidUrlWithQueryString(): void
    {
        $endpoint = new Endpoint('https://example.com/webhook?param=value');
        $this->assertEquals('https://example.com/webhook?param=value', $endpoint->value);
    }

    public function testConstructorWithValidHttpUrl(): void
    {
        $endpoint = new Endpoint('http://example.com/webhook');
        $this->assertEquals('http://example.com/webhook', $endpoint->value);
    }

    public function testConstructorWithEmptyStringThrowsException(): void
    {
        $this->expectException(InvalidEndpointException::class);
        $this->expectExceptionMessage('Endpoint must not be empty');

        new Endpoint('');
    }

    public function testConstructorWithInvalidUrlThrowsException(): void
    {
        $this->expectException(InvalidEndpointException::class);
        $this->expectExceptionMessage('Endpoint must be a valid URL');

        new Endpoint('not-a-valid-url');
    }

    public function testConstructorWithInvalidUrlMissingSchemeThrowsException(): void
    {
        $this->expectException(InvalidEndpointException::class);
        $this->expectExceptionMessage('Endpoint must be a valid URL');

        new Endpoint('example.com/webhook');
    }

    public function testConstructorWithSpacesThrowsException(): void
    {
        $this->expectException(InvalidEndpointException::class);
        $this->expectExceptionMessage('Endpoint must be a valid URL');

        new Endpoint('https://example com/webhook');
    }

    public function testConstructorWithValidUrlWithPath(): void
    {
        $endpoint = new Endpoint('https://api.example.com/v1/webhooks/job-status');
        $this->assertEquals('https://api.example.com/v1/webhooks/job-status', $endpoint->value);
    }

    public function testConstructorWithLocalhostUrl(): void
    {
        $endpoint = new Endpoint('http://localhost:3000/webhook');
        $this->assertEquals('http://localhost:3000/webhook', $endpoint->value);
    }

    public function testConstructorWithIpAddressUrl(): void
    {
        $endpoint = new Endpoint('http://192.168.1.1:8080/webhook');
        $this->assertEquals('http://192.168.1.1:8080/webhook', $endpoint->value);
    }
}
