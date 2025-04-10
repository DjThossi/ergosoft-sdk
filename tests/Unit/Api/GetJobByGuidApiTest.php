<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\GetJobByGuidApi;
use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Exception\JobNotFoundException;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetJobByGuidApiTest extends TestCase
{
    private Client $client;
    private JobMapper $jobMapper;
    private GetJobByGuidApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->jobMapper = $this->createMock(JobMapper::class);
        $this->api = new GetJobByGuidApi($this->client, $this->jobMapper);
    }

    public function testGetJobByGuid(): void
    {
        $jobGuid = 'test-job-guid';
        $responseJsonData = [
            'jobGuid' => $jobGuid,
            'jobId' => '12345',
            'jobName' => 'Test Job',
            'jobStatus' => 'RUNNING',
            'jobStatusDescription' => 'Job is running',
            'copies' => 1,
            'timeCreated' => '2023-01-01T12:00:00Z',
            'jobWidthMm' => 100,
            'jobLengthMm' => 200,
            'mediaWidthMm' => 100,
            'mediaLengthMm' => 200,
            'copiesPrinted' => 1,
            'printSecElapsed' => 10,
            'printSecRemaining' => 20,
            'timePrinted' => '2023-01-01T12:30:00Z',
            'copiesPrintedBefore' => 0,
            'printEnv' => 'PRINT_ENV',
            'owner' => 'admin',
            'printerId' => 'printer-1',
            'mediaType' => 'vinyl',
            'ppVersion' => '1.0',
            'customerInfo' => 'Customer Info',
            'preRippedInfo' => 'Pre-Ripped Info',
            'journal' => 'Journal'
        ];
        $expectedResponse = new Response(200, [], json_encode($responseJsonData, JSON_THROW_ON_ERROR));

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/get-job-by-guid/' . $jobGuid)
            ->willReturn($expectedResponse);

        $job = $this->createMock(Job::class);

        $this->jobMapper->expects($this->once())
            ->method('mapFromArray')
            ->with($this->callback(fn($data) => $data['jobGuid'] === $jobGuid))
            ->willReturn($job);

        $result = $this->api->getJobByGuid($jobGuid);

        $this->assertSame($job, $result);
    }

    public function testGetJobByGuidNotFound(): void
    {
        $jobGuid = 'non-existent-guid';
        $expectedResponse = new Response(200, [], json_encode([], JSON_THROW_ON_ERROR));

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/get-job-by-guid/' . $jobGuid)
            ->willReturn($expectedResponse);

        $this->jobMapper->expects($this->never())
            ->method('mapFromArray');

        $this->expectException(JobNotFoundException::class);
        $this->expectExceptionMessage(sprintf('Job with GUID "%s" not found', $jobGuid));

        $this->api->getJobByGuid($jobGuid);
    }
} 