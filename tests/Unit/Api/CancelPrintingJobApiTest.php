<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\CancelPrintingJobApi;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CancelPrintingJobApiTest extends TestCase
{
    /**
     * @var Client&\PHPUnit\Framework\MockObject\MockObject
     */
    private Client $client;

    private CancelPrintingJobApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->api = new CancelPrintingJobApi($this->client);
    }

    public function testCancelPrintingJobSuccess(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(200);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-printing-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelPrintingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(200, $statusCode->value);
        $this->assertTrue($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isOk());
        $this->assertFalse($statusCode->isNotFound());
    }

    public function testCancelPrintingJobWithBadRequest(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(400);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-printing-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelPrintingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(400, $statusCode->value);
        $this->assertFalse($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isBadRequest());
    }

    public function testCancelPrintingJobWithForbidden(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(403);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-printing-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelPrintingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(403, $statusCode->value);
        $this->assertTrue($statusCode->isForbidden());
    }

    public function testCancelPrintingJobWithNotFound(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(404);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-printing-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelPrintingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(404, $statusCode->value);
        $this->assertTrue($statusCode->isNotFound());
    }

    public function testCancelPrintingJobWithConflict(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(409);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-printing-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelPrintingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(409, $statusCode->value);
        $this->assertTrue($statusCode->isConflict());
    }

    public function testCancelPrintingJobWithServerError(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(500);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-printing-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelPrintingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(500, $statusCode->value);
        $this->assertTrue($statusCode->isServerError());
    }

    public function testCancelPrintingJobWithServiceUnavailable(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(503);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-printing-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelPrintingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(503, $statusCode->value);
        $this->assertTrue($statusCode->isServiceUnavailable());
    }

    public function testCancelPrintingJobWithDifferentGuid(): void
    {
        $jobGuid = new JobGuid('87654321-4321-4321-4321-cba987654321');
        $expectedResponse = new Response(200);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/cancel-printing-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->cancelPrintingJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(200, $statusCode->value);
        $this->assertTrue($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isOk());
    }
}
