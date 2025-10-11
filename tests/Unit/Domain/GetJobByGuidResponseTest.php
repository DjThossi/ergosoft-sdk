<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DateTimeImmutable;
use DjThossi\ErgosoftSdk\Domain\GetJobByGuidResponse;
use DjThossi\ErgosoftSdk\Domain\GetJobByGuidResponseBody;
use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\JobId;
use DjThossi\ErgosoftSdk\Domain\JobName;
use DjThossi\ErgosoftSdk\Domain\JobStatus;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use PHPUnit\Framework\TestCase;

class GetJobByGuidResponseTest extends TestCase
{
    public function testConstructorAndProperties(): void
    {
        $statusCode = new StatusCode(200);
        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Test Job');
        $responseBody = new GetJobByGuidResponseBody('{"jobGuid":"12345678-1234-1234-1234-123456789012"}');

        $response = new GetJobByGuidResponse($statusCode, $job, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertSame($job, $response->job);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals(200, $response->statusCode->value);
    }

    public function testConstructorWithDifferentStatusCodes(): void
    {
        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Test Job');
        $responseBody = new GetJobByGuidResponseBody('{"jobGuid":"12345678-1234-1234-1234-123456789012"}');

        $response200 = new GetJobByGuidResponse(new StatusCode(200), $job, $responseBody);
        $this->assertEquals(200, $response200->statusCode->value);
        $this->assertTrue($response200->statusCode->isSuccessful());

        $response404 = new GetJobByGuidResponse(new StatusCode(404), $job, $responseBody);
        $this->assertEquals(404, $response404->statusCode->value);
        $this->assertTrue($response404->statusCode->isNotFound());
    }

    public function testResponseBodyIsJsonResponseBody(): void
    {
        $statusCode = new StatusCode(200);
        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Test Job');
        $responseBody = new GetJobByGuidResponseBody('{"jobGuid":"12345678-1234-1234-1234-123456789012"}');

        $response = new GetJobByGuidResponse($statusCode, $job, $responseBody);

        $this->assertTrue($response->responseBody->isValidJson());
        $this->assertIsArray($response->responseBody->getDecodedJson());
    }

    public function testMultipleInstancesAreSeparate(): void
    {
        $job1 = $this->createJob('12345678-1234-1234-1234-123456789001', 1, 'Job 1');
        $job2 = $this->createJob('22345678-1234-1234-1234-123456789002', 2, 'Job 2');

        $response1 = new GetJobByGuidResponse(
            new StatusCode(200),
            $job1,
            new GetJobByGuidResponseBody('{"jobGuid":"12345678-1234-1234-1234-123456789001"}')
        );

        $response2 = new GetJobByGuidResponse(
            new StatusCode(404),
            $job2,
            new GetJobByGuidResponseBody('{"jobGuid":"22345678-1234-1234-1234-123456789002"}')
        );

        $this->assertEquals(200, $response1->statusCode->value);
        $this->assertNotNull($response1->job);
        $this->assertEquals('12345678-1234-1234-1234-123456789001', $response1->job->getJobGuid()->value);

        $this->assertEquals(404, $response2->statusCode->value);
        $this->assertNotNull($response2->job);
        $this->assertEquals('22345678-1234-1234-1234-123456789002', $response2->job->getJobGuid()->value);
    }

    public function testConstructorWithNullJob(): void
    {
        $statusCode = new StatusCode(404);
        $responseBody = new GetJobByGuidResponseBody('{"error":"Job not found"}');

        $response = new GetJobByGuidResponse($statusCode, null, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertNull($response->job);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals(404, $response->statusCode->value);
    }

    public function testHasJobReturnsTrueWhenJobExists(): void
    {
        $statusCode = new StatusCode(200);
        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Test Job');
        $responseBody = new GetJobByGuidResponseBody('{"jobGuid":"12345678-1234-1234-1234-123456789012"}');

        $response = new GetJobByGuidResponse($statusCode, $job, $responseBody);

        $this->assertTrue($response->hasJob());
    }

    public function testHasJobReturnsFalseWhenJobIsNull(): void
    {
        $statusCode = new StatusCode(404);
        $responseBody = new GetJobByGuidResponseBody('"Job not found"');

        $response = new GetJobByGuidResponse($statusCode, null, $responseBody);

        $this->assertFalse($response->hasJob());
    }

    public function testResponseWithNullJobAndEmptyData(): void
    {
        $statusCode = new StatusCode(200);
        $responseBody = new GetJobByGuidResponseBody('[]');

        $response = new GetJobByGuidResponse($statusCode, null, $responseBody);

        $this->assertEquals(200, $response->statusCode->value);
        $this->assertNull($response->job);
        $this->assertFalse($response->hasJob());
        $this->assertTrue($response->responseBody->isValidJson());
    }

    private function createJob(string $guidValue, int $jobIdValue, string $jobNameValue): Job
    {
        return new Job(
            jobGuid: new JobGuid($guidValue),
            jobId: new JobId($jobIdValue),
            jobName: new JobName($jobNameValue),
            jobStatus: new JobStatus('RUNNING'),
            jobStatusDescription: 'Job is running',
            copies: 1,
            timeCreated: new DateTimeImmutable('2023-01-01T12:00:00Z'),
            jobWidthMm: 100,
            jobLengthMm: 200,
            mediaWidthMm: 100.0,
            mediaLengthMm: 200.0,
            copiesPrinted: 0,
            printSecElapsed: 0,
            printSecRemaining: 100,
            timePrinted: null,
            copiesPrintedBefore: 0,
            printEnv: 'PRINT_ENV',
            owner: 'admin',
            printerId: 'printer-1',
            mediaType: 'vinyl',
            ppVersion: '1.0',
            customerInfo: 'Customer Info',
            preRippedInfo: 'Pre-Ripped Info',
            journal: 'Journal',
        );
    }
}
