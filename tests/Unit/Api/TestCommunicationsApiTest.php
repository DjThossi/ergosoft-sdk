<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\TestCommunicationsApi;
use DjThossi\ErgosoftSdk\Domain\TestCommunicationsResponse;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TestCommunicationsApiTest extends TestCase
{
    /**
     * @var Client&\PHPUnit\Framework\MockObject\MockObject
     */
    private Client $client;

    private TestCommunicationsApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->api = new TestCommunicationsApi($this->client);
    }

    public function testTestCommunicationsSuccess(): void
    {
        $expectedResponse = new Response(200, [], '{"message": "Ergosoft Communications is alive."}');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/test-communications')
            ->willReturn($expectedResponse);

        $result = $this->api->testCommunications();

        $this->assertInstanceOf(TestCommunicationsResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isSuccessful());
        $this->assertTrue($result->statusCode->isOk());
        $this->assertEquals('{"message": "Ergosoft Communications is alive."}', $result->responseBody->value);
    }

    public function testTestCommunicationsSuccessWithEmptyBody(): void
    {
        $expectedResponse = new Response(200, [], '');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/test-communications')
            ->willReturn($expectedResponse);

        $result = $this->api->testCommunications();

        $this->assertInstanceOf(TestCommunicationsResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isSuccessful());
        $this->assertEquals('', $result->responseBody->value);
    }

    public function testTestCommunicationsWithServerError(): void
    {
        $expectedResponse = new Response(500, [], 'Internal server error');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/test-communications')
            ->willReturn($expectedResponse);

        $result = $this->api->testCommunications();

        $this->assertInstanceOf(TestCommunicationsResponse::class, $result);
        $this->assertEquals(500, $result->statusCode->value);
        $this->assertFalse($result->statusCode->isSuccessful());
        $this->assertTrue($result->statusCode->isServerError());
        $this->assertEquals('Internal server error', $result->responseBody->value);
    }

    public function testTestCommunicationsWithServerErrorEmptyBody(): void
    {
        $expectedResponse = new Response(500, [], '');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/test-communications')
            ->willReturn($expectedResponse);

        $result = $this->api->testCommunications();

        $this->assertInstanceOf(TestCommunicationsResponse::class, $result);
        $this->assertEquals(500, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isServerError());
        $this->assertEquals('', $result->responseBody->value);
    }

    public function testTestCommunicationsWithServiceUnavailable(): void
    {
        $expectedResponse = new Response(503, [], 'Service unavailable');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/test-communications')
            ->willReturn($expectedResponse);

        $result = $this->api->testCommunications();

        $this->assertInstanceOf(TestCommunicationsResponse::class, $result);
        $this->assertEquals(503, $result->statusCode->value);
        $this->assertFalse($result->statusCode->isSuccessful());
        $this->assertTrue($result->statusCode->isServiceUnavailable());
        $this->assertEquals('Service unavailable', $result->responseBody->value);
    }

    public function testTestCommunicationsWithServiceUnavailableEmptyBody(): void
    {
        $expectedResponse = new Response(503, [], '');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/test-communications')
            ->willReturn($expectedResponse);

        $result = $this->api->testCommunications();

        $this->assertInstanceOf(TestCommunicationsResponse::class, $result);
        $this->assertEquals(503, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isServiceUnavailable());
        $this->assertEquals('', $result->responseBody->value);
    }
}
