<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Domain\StringResponseBody;
use DjThossi\ErgosoftSdk\Domain\UnsubscribeJobStatusResponse;
use PHPUnit\Framework\TestCase;

class UnsubscribeJobStatusResponseTest extends TestCase
{
    public function testConstructorAndProperties(): void
    {
        $statusCode = new StatusCode(200);
        $responseBody = new StringResponseBody('Unsubscription successful');

        $response = new UnsubscribeJobStatusResponse($statusCode, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('Unsubscription successful', $response->responseBody->value);
    }

    public function testConstructorWithEmptyResponseBody(): void
    {
        $statusCode = new StatusCode(200);
        $responseBody = new StringResponseBody('');

        $response = new UnsubscribeJobStatusResponse($statusCode, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('', $response->responseBody->value);
    }

    public function testConstructorWithBadRequestStatusCode(): void
    {
        $statusCode = new StatusCode(400);
        $responseBody = new StringResponseBody('Bad request error message');

        $response = new UnsubscribeJobStatusResponse($statusCode, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertEquals(400, $response->statusCode->value);
        $this->assertTrue($response->statusCode->isBadRequest());
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('Bad request error message', $response->responseBody->value);
    }

    public function testConstructorWithNotFoundStatusCode(): void
    {
        $statusCode = new StatusCode(404);
        $responseBody = new StringResponseBody('Subscription not found');

        $response = new UnsubscribeJobStatusResponse($statusCode, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertEquals(404, $response->statusCode->value);
        $this->assertTrue($response->statusCode->isNotFound());
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('Subscription not found', $response->responseBody->value);
    }

    public function testMultipleInstancesAreSeparate(): void
    {
        $response1 = new UnsubscribeJobStatusResponse(new StatusCode(200), new StringResponseBody('Response 1'));
        $response2 = new UnsubscribeJobStatusResponse(new StatusCode(404), new StringResponseBody('Response 2'));

        $this->assertEquals(200, $response1->statusCode->value);
        $this->assertEquals('Response 1', $response1->responseBody->value);

        $this->assertEquals(404, $response2->statusCode->value);
        $this->assertEquals('Response 2', $response2->responseBody->value);
    }
}
