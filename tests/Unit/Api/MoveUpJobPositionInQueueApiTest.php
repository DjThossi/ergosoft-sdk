<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\MoveUpJobPositionInQueueApi;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\MoveUpJobPositionInQueueResponse;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class MoveUpJobPositionInQueueApiTest extends TestCase
{
    /**
     * @var Client&\PHPUnit\Framework\MockObject\MockObject
     */
    private Client $client;

    private MoveUpJobPositionInQueueApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->api = new MoveUpJobPositionInQueueApi($this->client);
    }

    public function testSuccess(): void
    {
        $up = new JobGuid('11111111-1111-1111-1111-111111111111');
        $down = new JobGuid('22222222-2222-2222-2222-222222222222');
        $expectedResponse = new Response(200, [], '{"result":"ok"}');

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/move-up-job-position-in-queue/' . $up->value . '/' . $down->value)
            ->willReturn($expectedResponse);

        $result = $this->api->moveUp($up, $down);

        $this->assertInstanceOf(MoveUpJobPositionInQueueResponse::class, $result);
        $this->assertEquals(200, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isSuccessful());
        $this->assertTrue($result->statusCode->isOk());
        $this->assertEquals('{"result":"ok"}', $result->responseBody->value);
    }

    public function testWithEmptyBody(): void
    {
        $up = new JobGuid('aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa');
        $down = new JobGuid('bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbb');
        $expectedResponse = new Response(200, [], '');

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/move-up-job-position-in-queue/' . $up->value . '/' . $down->value)
            ->willReturn($expectedResponse);

        $result = $this->api->moveUp($up, $down);

        $this->assertEquals('', $result->responseBody->value);
    }

    public function testBadRequest(): void
    {
        $up = new JobGuid('33333333-3333-3333-3333-333333333333');
        $down = new JobGuid('44444444-4444-4444-4444-444444444444');
        $expectedResponse = new Response(400, [], '{"error":"Bad Request"}');

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/move-up-job-position-in-queue/' . $up->value . '/' . $down->value)
            ->willReturn($expectedResponse);

        $result = $this->api->moveUp($up, $down);

        $this->assertEquals(400, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isBadRequest());
    }

    public function testForbidden(): void
    {
        $up = new JobGuid('55555555-5555-5555-5555-555555555555');
        $down = new JobGuid('66666666-6666-6666-6666-666666666666');
        $expectedResponse = new Response(403);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/move-up-job-position-in-queue/' . $up->value . '/' . $down->value)
            ->willReturn($expectedResponse);

        $result = $this->api->moveUp($up, $down);

        $this->assertEquals(403, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isForbidden());
    }

    public function testNotFound(): void
    {
        $up = new JobGuid('77777777-7777-7777-7777-777777777777');
        $down = new JobGuid('88888888-8888-8888-8888-888888888888');
        $expectedResponse = new Response(404);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/move-up-job-position-in-queue/' . $up->value . '/' . $down->value)
            ->willReturn($expectedResponse);

        $result = $this->api->moveUp($up, $down);

        $this->assertEquals(404, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isNotFound());
    }

    public function testConflict(): void
    {
        $up = new JobGuid('99999999-9999-9999-9999-999999999999');
        $down = new JobGuid('aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaab');
        $expectedResponse = new Response(409);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/move-up-job-position-in-queue/' . $up->value . '/' . $down->value)
            ->willReturn($expectedResponse);

        $result = $this->api->moveUp($up, $down);

        $this->assertEquals(409, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isConflict());
    }

    public function testServerError(): void
    {
        $up = new JobGuid('bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbc');
        $down = new JobGuid('cccccccc-cccc-cccc-cccc-cccccccccccc');
        $expectedResponse = new Response(500, [], 'Internal server error');

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/move-up-job-position-in-queue/' . $up->value . '/' . $down->value)
            ->willReturn($expectedResponse);

        $result = $this->api->moveUp($up, $down);

        $this->assertEquals(500, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isServerError());
        $this->assertEquals('Internal server error', $result->responseBody->value);
    }

    public function testServiceUnavailable(): void
    {
        $up = new JobGuid('dddddddd-dddd-dddd-dddd-dddddddddddd');
        $down = new JobGuid('eeeeeeee-eeee-eeee-eeee-eeeeeeeeeeee');
        $expectedResponse = new Response(503, [], 'Service unavailable');

        $this->client->expects($this->once())
            ->method('put')
            ->with('/Trickle/move-up-job-position-in-queue/' . $up->value . '/' . $down->value)
            ->willReturn($expectedResponse);

        $result = $this->api->moveUp($up, $down);

        $this->assertEquals(503, $result->statusCode->value);
        $this->assertTrue($result->statusCode->isServiceUnavailable());
        $this->assertEquals('Service unavailable', $result->responseBody->value);
    }
}
