<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Domain\SubmitDeltaXmlFileResponse;
use DjThossi\ErgosoftSdk\Domain\SubmitDeltaXmlFileResponseBody;
use PHPUnit\Framework\TestCase;

class SubmitDeltaXmlFileResponseTest extends TestCase
{
    public function testConstructorAndProperties(): void
    {
        $statusCode = new StatusCode(200);
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $responseBody = new SubmitDeltaXmlFileResponseBody('"12345678-1234-1234-1234-123456789012"');

        $response = new SubmitDeltaXmlFileResponse($statusCode, $jobGuid, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertSame($jobGuid, $response->jobGuid);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('"12345678-1234-1234-1234-123456789012"', $response->responseBody->value);
    }

    public function testConstructorWithDifferentJobGuid(): void
    {
        $statusCode = new StatusCode(200);
        $jobGuid = new JobGuid('4f1175eb-c6ca-4e9e-9edd-36babf2048e0');
        $responseBody = new SubmitDeltaXmlFileResponseBody('"4f1175eb-c6ca-4e9e-9edd-36babf2048e0"');

        $response = new SubmitDeltaXmlFileResponse($statusCode, $jobGuid, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertSame($jobGuid, $response->jobGuid);
        $this->assertEquals('4f1175eb-c6ca-4e9e-9edd-36babf2048e0', $response->jobGuid->value);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertTrue($response->responseBody->isValidJson());
    }

    public function testConstructorWithServerErrorStatusCode(): void
    {
        $statusCode = new StatusCode(500);
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $responseBody = new SubmitDeltaXmlFileResponseBody('Internal server error');

        $response = new SubmitDeltaXmlFileResponse($statusCode, $jobGuid, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertEquals(500, $response->statusCode->value);
        $this->assertTrue($response->statusCode->isServerError());
        $this->assertSame($jobGuid, $response->jobGuid);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('Internal server error', $response->responseBody->value);
    }

    public function testMultipleInstancesAreSeparate(): void
    {
        $response1 = new SubmitDeltaXmlFileResponse(
            new StatusCode(200),
            new JobGuid('12345678-1234-1234-1234-123456789012'),
            new SubmitDeltaXmlFileResponseBody('"12345678-1234-1234-1234-123456789012"')
        );
        $response2 = new SubmitDeltaXmlFileResponse(
            new StatusCode(500),
            new JobGuid('4f1175eb-c6ca-4e9e-9edd-36babf2048e0'),
            new SubmitDeltaXmlFileResponseBody('Error')
        );

        $this->assertEquals(200, $response1->statusCode->value);
        $this->assertEquals('12345678-1234-1234-1234-123456789012', $response1->jobGuid->value);
        $this->assertEquals('"12345678-1234-1234-1234-123456789012"', $response1->responseBody->value);

        $this->assertEquals(500, $response2->statusCode->value);
        $this->assertEquals('4f1175eb-c6ca-4e9e-9edd-36babf2048e0', $response2->jobGuid->value);
        $this->assertEquals('Error', $response2->responseBody->value);
    }
}
