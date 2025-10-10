<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\SubscribeJobStatusApi;
use DjThossi\ErgosoftSdk\Domain\Endpoint;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\SubscribeJobStatusResponse;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Psr7\Response;

use const JSON_THROW_ON_ERROR;

use PHPUnit\Framework\TestCase;

class SubscribeJobStatusApiTest extends TestCase
{
    /**
     * @var Client&\PHPUnit\Framework\MockObject\MockObject
     */
    private Client $client;

    private SubscribeJobStatusApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->api = new SubscribeJobStatusApi($this->client);
    }

    public function testSubscribeJobStatusSuccess(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $endpoint = new Endpoint('https://example.com/webhook');
        $expectedResponse = new Response(200, [], 'Subscription successful');

        $expectedRequestBody = json_encode([
            'jobGuid' => '12345678-1234-1234-1234-123456789abc',
            'endpoint' => 'https://example.com/webhook',
        ], JSON_THROW_ON_ERROR);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/Trickle/subscribe-job-status', $expectedRequestBody)
            ->willReturn($expectedResponse);

        $result = $this->api->subscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(SubscribeJobStatusResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isSuccessful());
        $this->assertTrue($result->statusCode->isOk());
        $this->assertEquals('Subscription successful', $result->responseBody->value);
    }

    public function testSubscribeJobStatusWithBadRequest(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $endpoint = new Endpoint('https://example.com/webhook');
        $expectedResponse = new Response(400, [], 'Bad request error');

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($expectedResponse);

        $result = $this->api->subscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(SubscribeJobStatusResponse::class, $result);
        $this->assertEquals(400, $result->statusCode->value);
        $this->assertFalse($result->statusCode->isSuccessful());
        $this->assertTrue($result->statusCode->isBadRequest());
        $this->assertEquals('Bad request error', $result->responseBody->value);
    }

    public function testSubscribeJobStatusWithEmptyResponseBody(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $endpoint = new Endpoint('https://example.com/webhook');
        $expectedResponse = new Response(200, [], '');

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($expectedResponse);

        $result = $this->api->subscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(SubscribeJobStatusResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertEquals('', $result->responseBody->value);
    }

    public function testSubscribeJobStatusWithDifferentGuidAndEndpoint(): void
    {
        $jobGuid = new JobGuid('87654321-4321-4321-4321-cba987654321');
        $endpoint = new Endpoint('http://localhost:8080/api/webhook');
        $expectedResponse = new Response(200, [], 'Subscribed');

        $expectedRequestBody = json_encode([
            'jobGuid' => '87654321-4321-4321-4321-cba987654321',
            'endpoint' => 'http://localhost:8080/api/webhook',
        ], JSON_THROW_ON_ERROR);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/Trickle/subscribe-job-status', $expectedRequestBody)
            ->willReturn($expectedResponse);

        $result = $this->api->subscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(SubscribeJobStatusResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertEquals('Subscribed', $result->responseBody->value);
    }

    public function testSubscribeJobStatusWithJsonResponseBody(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $endpoint = new Endpoint('https://example.com/webhook');
        $jsonResponse = '{"subscriptionId": "sub-123", "status": "active"}';
        $expectedResponse = new Response(200, [], $jsonResponse);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($expectedResponse);

        $result = $this->api->subscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(SubscribeJobStatusResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertEquals($jsonResponse, $result->responseBody->value);
    }

    public function testSubscribeJobStatusRequestBodyStructure(): void
    {
        $jobGuid = new JobGuid('aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee');
        $endpoint = new Endpoint('https://api.example.com/v1/webhooks/job-status');
        $expectedResponse = new Response(200, [], 'OK');

        $this->client->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('/Trickle/subscribe-job-status'),
                $this->callback(function ($requestBody) {
                    $decoded = json_decode($requestBody, true);

                    return isset($decoded['jobGuid'])
                        && isset($decoded['endpoint'])
                        && $decoded['jobGuid'] === 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee'
                        && $decoded['endpoint'] === 'https://api.example.com/v1/webhooks/job-status';
                })
            )
            ->willReturn($expectedResponse);

        $result = $this->api->subscribeJobStatus($jobGuid, $endpoint);

        $this->assertInstanceOf(SubscribeJobStatusResponse::class, $result);
    }
}
