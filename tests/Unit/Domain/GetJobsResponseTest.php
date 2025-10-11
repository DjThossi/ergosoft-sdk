<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DateTimeImmutable;
use DjThossi\ErgosoftSdk\Domain\GetJobsResponse;
use DjThossi\ErgosoftSdk\Domain\GetJobsResponseBody;
use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Domain\JobCollection;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\JobId;
use DjThossi\ErgosoftSdk\Domain\JobName;
use DjThossi\ErgosoftSdk\Domain\JobStatus;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use PHPUnit\Framework\TestCase;

class GetJobsResponseTest extends TestCase
{
    public function testConstructorAndProperties(): void
    {
        $statusCode = new StatusCode(200);
        $jobCollection = new JobCollection();
        $responseBody = new GetJobsResponseBody('[]');

        $response = new GetJobsResponse($statusCode, $jobCollection, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertSame($jobCollection, $response->jobs);
        $this->assertSame($responseBody, $response->responseBody);
        $this->assertEquals('[]', $response->responseBody->value);
    }

    public function testConstructorWithJobsInCollection(): void
    {
        $statusCode = new StatusCode(200);
        $jobCollection = new JobCollection();

        $job = new Job(
            new JobGuid('12345678-1234-1234-1234-123456789012'),
            new JobId(1),
            new JobName('Test Job'),
            new JobStatus('RUNNING'),
            'Running',
            1,
            new DateTimeImmutable(),
            100,
            200,
            100.0,
            200.0,
            0,
            0,
            100,
            null,
            0,
            'env',
            'owner',
            'printer-1',
            'vinyl',
            '1.0',
            'info',
            'ripped',
            'journal'
        );

        $jobCollection->add($job);

        $responseBody = new GetJobsResponseBody('[{"jobGuid":"12345678-1234-1234-1234-123456789012"}]');

        $response = new GetJobsResponse($statusCode, $jobCollection, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertSame($jobCollection, $response->jobs);
        $this->assertCount(1, $response->jobs);
        $this->assertSame($responseBody, $response->responseBody);
    }

    public function testConstructorWithServerErrorStatusCode(): void
    {
        $statusCode = new StatusCode(500);
        $jobCollection = new JobCollection();
        $responseBody = new GetJobsResponseBody('Internal server error');

        $response = new GetJobsResponse($statusCode, $jobCollection, $responseBody);

        $this->assertSame($statusCode, $response->statusCode);
        $this->assertEquals(500, $response->statusCode->value);
        $this->assertTrue($response->statusCode->isServerError());
        $this->assertSame($jobCollection, $response->jobs);
        $this->assertSame($responseBody, $response->responseBody);
    }

    public function testMultipleInstancesAreSeparate(): void
    {
        $collection1 = new JobCollection();
        $collection2 = new JobCollection();

        $response1 = new GetJobsResponse(
            new StatusCode(200),
            $collection1,
            new GetJobsResponseBody('[]')
        );
        $response2 = new GetJobsResponse(
            new StatusCode(500),
            $collection2,
            new GetJobsResponseBody('Error')
        );

        $this->assertEquals(200, $response1->statusCode->value);
        $this->assertCount(0, $response1->jobs);
        $this->assertEquals('[]', $response1->responseBody->value);

        $this->assertEquals(500, $response2->statusCode->value);
        $this->assertCount(0, $response2->jobs);
        $this->assertEquals('Error', $response2->responseBody->value);
    }
}
