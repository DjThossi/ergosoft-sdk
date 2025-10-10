<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Domain\TestCommunicationsResponse;
use DjThossi\ErgosoftSdk\Domain\TestCommunicationsResponseBody;
use PHPUnit\Framework\TestCase;

class TestCommunicationsResponseTest extends TestCase
{
    public function testConstructorAndProperties(): void
    {
        $statusCode = new StatusCode(200);
        $responseBody = new TestCommunicationsResponseBody('{"message": "Ergosoft Communications is alive."}');

        $response = new TestCommunicationsResponse($statusCode, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('{"message": "Ergosoft Communications is alive."}', $response->responseBody->value);
    }

    public function testConstructorWithEmptyResponseBody(): void
    {
        $statusCode = new StatusCode(200);
        $responseBody = new TestCommunicationsResponseBody('');

        $response = new TestCommunicationsResponse($statusCode, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('', $response->responseBody->value);
    }

    public function testConstructorWithServerErrorStatusCode(): void
    {
        $statusCode = new StatusCode(500);
        $responseBody = new TestCommunicationsResponseBody('Internal server error');

        $response = new TestCommunicationsResponse($statusCode, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertEquals(500, $response->statusCode->value);
        $this->assertTrue($response->statusCode->isServerError());
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('Internal server error', $response->responseBody->value);
    }

    public function testConstructorWithServiceUnavailableStatusCode(): void
    {
        $statusCode = new StatusCode(503);
        $responseBody = new TestCommunicationsResponseBody('Service unavailable');

        $response = new TestCommunicationsResponse($statusCode, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertEquals(503, $response->statusCode->value);
        $this->assertTrue($response->statusCode->isServiceUnavailable());
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('Service unavailable', $response->responseBody->value);
    }

    public function testMultipleInstancesAreSeparate(): void
    {
        $response1 = new TestCommunicationsResponse(new StatusCode(200), new TestCommunicationsResponseBody('Response 1'));
        $response2 = new TestCommunicationsResponse(new StatusCode(500), new TestCommunicationsResponseBody('Response 2'));

        $this->assertEquals(200, $response1->statusCode->value);
        $this->assertEquals('Response 1', $response1->responseBody->value);

        $this->assertEquals(500, $response2->statusCode->value);
        $this->assertEquals('Response 2', $response2->responseBody->value);
    }
}
