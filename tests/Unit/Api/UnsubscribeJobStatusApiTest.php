<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\UnsubscribeJobStatusApi;
use DjThossi\ErgosoftSdk\Domain\Endpoint;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\UnsubscribeJobStatusResponse;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class UnsubscribeJobStatusApiTest extends TestCase
{
    /**
     * @var Client&\PHPUnit\Framework\MockObject\MockObject
     */
    private Client $client;

    private UnsubscribeJobStatusApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->api = new UnsubscribeJobStatusApi($this->client);
    }

    public function testUnsubscribeJobStatusSuccess(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $endpoint = new Endpoint('https://example.com/webhook');
        $expectedResponse = new Response(200, [], 'Unsubscription successful');

        $expectedUrl = '/Trickle/unsubscribe-job-status/12345678-1234-1234-1234-123456789abc?endpoint=' . urlencode('https://example.com/webhook');

        $this->client->expects($this->once())
            ->method('delete')
            ->with($expectedUrl)
            ->willReturn($expectedResponse);

        $result = $this->api->unsubscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(UnsubscribeJobStatusResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isSuccessful());
        $this->assertTrue($result->statusCode->isOk());
        $this->assertEquals('Unsubscription successful', $result->responseBody->value);
    }

    public function testUnsubscribeJobStatusWithBadRequest(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $endpoint = new Endpoint('https://example.com/webhook');
        $expectedResponse = new Response(400, [], 'Bad request error');

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($expectedResponse);

        $result = $this->api->unsubscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(UnsubscribeJobStatusResponse::class, $result);
        $this->assertEquals(400, $result->statusCode->value);
        $this->assertFalse($result->statusCode->isSuccessful());
        $this->assertTrue($result->statusCode->isBadRequest());
        $this->assertEquals('Bad request error', $result->responseBody->value);
    }

    public function testUnsubscribeJobStatusWithNotFound(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $endpoint = new Endpoint('https://example.com/webhook');
        $expectedResponse = new Response(404, [], 'Subscription not found');

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($expectedResponse);

        $result = $this->api->unsubscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(UnsubscribeJobStatusResponse::class, $result);
        $this->assertEquals(404, $result->statusCode->value);
        $this->assertFalse($result->statusCode->isSuccessful());
        $this->assertTrue($result->statusCode->isNotFound());
        $this->assertEquals('Subscription not found', $result->responseBody->value);
    }

    public function testUnsubscribeJobStatusWithEmptyResponseBody(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $endpoint = new Endpoint('https://example.com/webhook');
        $expectedResponse = new Response(200, [], '');

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($expectedResponse);

        $result = $this->api->unsubscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(UnsubscribeJobStatusResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertEquals('', $result->responseBody->value);
    }

    public function testUnsubscribeJobStatusWithDifferentGuidAndEndpoint(): void
    {
        $jobGuid = new JobGuid('87654321-4321-4321-4321-cba987654321');
        $endpoint = new Endpoint('http://localhost:8080/api/webhook');
        $expectedResponse = new Response(200, [], 'Unsubscribed');

        $expectedUrl = '/Trickle/unsubscribe-job-status/87654321-4321-4321-4321-cba987654321?endpoint=' . urlencode('http://localhost:8080/api/webhook');

        $this->client->expects($this->once())
            ->method('delete')
            ->with($expectedUrl)
            ->willReturn($expectedResponse);

        $result = $this->api->unsubscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(UnsubscribeJobStatusResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertEquals('Unsubscribed', $result->responseBody->value);
    }

    public function testUnsubscribeJobStatusUrlEncodesEndpoint(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $endpoint = new Endpoint('https://example.com/webhook?param=value&other=test');
        $expectedResponse = new Response(200, [], 'OK');

        $this->client->expects($this->once())
            ->method('delete')
            ->with($this->callback(function ($url) {
                return str_contains($url, urlencode('https://example.com/webhook?param=value&other=test'));
            }))
            ->willReturn($expectedResponse);

        $result = $this->api->unsubscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(UnsubscribeJobStatusResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
    }
}
