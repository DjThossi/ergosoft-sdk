<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\DeleteJobApi;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class DeleteJobApiTest extends TestCase
{
    /**
     * @var Client&\PHPUnit\Framework\MockObject\MockObject
     */
    private Client $client;

    private DeleteJobApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->api = new DeleteJobApi($this->client);
    }

    public function testDeleteJobSuccess(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(200);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/Trickle/delete-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->deleteJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(200, $statusCode->value);
        $this->assertTrue($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isOk());
        $this->assertFalse($statusCode->isNoContent());
        $this->assertFalse($statusCode->isNotFound());
    }

    public function testDeleteJobWithNoContent(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
        $expectedResponse = new Response(204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/Trickle/delete-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->deleteJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(204, $statusCode->value);
        $this->assertTrue($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isNoContent());
        $this->assertFalse($statusCode->isOk());
        $this->assertFalse($statusCode->isNotFound());
    }

    public function testDeleteJobWithDifferentGuid(): void
    {
        $jobGuid = new JobGuid('87654321-4321-4321-4321-cba987654321');
        $expectedResponse = new Response(200);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/Trickle/delete-job/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $statusCode = $this->api->deleteJob($jobGuid);

        $this->assertInstanceOf(StatusCode::class, $statusCode);
        $this->assertEquals(200, $statusCode->value);
        $this->assertTrue($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isOk());
    }
}
