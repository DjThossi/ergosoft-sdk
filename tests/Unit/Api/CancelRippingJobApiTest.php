<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\CancelRippingJobApi;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CancelRippingJobApiTest extends TestCase
{
    /**
     * @var Client&\PHPUnit\Framework\MockObject\MockObject
     */
    private Client $client;

    private CancelRippingJobApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->api = new CancelRippingJobApi($this->client);
    }

    public function testCancelRippingJobSuccess(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(200);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-ripping-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelRippingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(200, $statusCode->value);
        $this->assertTrue($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isOk());
        $this->assertFalse($statusCode->isNotFound());
    }

    public function testCancelRippingJobWithBadRequest(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(400);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-ripping-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelRippingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(400, $statusCode->value);
        $this->assertFalse($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isBadRequest());
    }

    public function testCancelRippingJobWithForbidden(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(403);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-ripping-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelRippingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(403, $statusCode->value);
        $this->assertTrue($statusCode->isForbidden());
    }

    public function testCancelRippingJobWithNotFound(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(404);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-ripping-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelRippingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(404, $statusCode->value);
        $this->assertTrue($statusCode->isNotFound());
    }

    public function testCancelRippingJobWithConflict(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(409);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-ripping-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelRippingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(409, $statusCode->value);
        $this->assertTrue($statusCode->isConflict());
    }

    public function testCancelRippingJobWithServerError(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(500);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-ripping-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelRippingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(500, $statusCode->value);
        $this->assertTrue($statusCode->isServerError());
    }

    public function testCancelRippingJobWithServiceUnavailable(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(503);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-ripping-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelRippingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(503, $statusCode->value);
        $this->assertTrue($statusCode->isServiceUnavailable());
    }

    public function testCancelRippingJobWithDifferentGuid(): void
    {
        $jobGuid = new JobGuid('87654321-4321-4321-4321-cba987654321');
        $expectedResponse = new Response(200);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-ripping-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelRippingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(200, $statusCode->value);
        $this->assertTrue($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isOk());
    }
}
