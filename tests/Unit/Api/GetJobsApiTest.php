<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetJobsApiTest extends TestCase
{
    private Client $client;
    private JobMapper $jobMapper;
    private GetJobsApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->jobMapper = $this->createMock(JobMapper::class);
        $this->api = new GetJobsApi($this->client, $this->jobMapper);
    }

    public function testGetJobs(): void
    {
        $expectedResponse = new Response(200, [], json_encode([
            [
                'jobGuid' => 'test-guid-1',
                'jobId' => '12345',
                'jobName' => 'Test Job 1',
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
            ],
            [
                'jobGuid' => 'test-guid-2',
                'jobId' => '67890',
                'jobName' => 'Test Job 2',
                'jobStatus' => 'DONE',
                'jobStatusDescription' => 'Job is done',
                'copies' => 2,
                'timeCreated' => '2023-01-02T12:00:00Z',
                'jobWidthMm' => 150,
                'jobLengthMm' => 250,
                'mediaWidthMm' => 150,
                'mediaLengthMm' => 250,
                'copiesPrinted' => 2,
                'printSecElapsed' => 15,
                'printSecRemaining' => 0,
                'timePrinted' => '2023-01-02T12:45:00Z',
                'copiesPrintedBefore' => 0,
                'printEnv' => 'PRINT_ENV',
                'owner' => 'admin',
                'printerId' => 'printer-2',
                'mediaType' => 'paper',
                'ppVersion' => '1.0',
                'customerInfo' => 'Customer Info',
                'preRippedInfo' => 'Pre-Ripped Info',
                'journal' => 'Journal'
            ]
        ], JSON_THROW_ON_ERROR));

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/get-jobs')
            ->willReturn($expectedResponse);

        $job1 = $this->createMock(Job::class);
        $job2 = $this->createMock(Job::class);

        $this->jobMapper->expects($this->exactly(2))
            ->method('mapFromArray')
            ->willReturnCallback(function ($data) use ($job1, $job2) {
                if ($data['jobGuid'] === 'test-guid-1') {
                    return $job1;
                }
                if ($data['jobGuid'] === 'test-guid-2') {
                    return $job2;
                }
                return null;
            });

        $result = $this->api->getJobs();

        $this->assertCount(2, $result);
        $this->assertSame($job1, $result[0]);
        $this->assertSame($job2, $result[1]);
    }

    public function testGetJobsEmpty(): void
    {
        $expectedResponse = new Response(200, [], json_encode([], JSON_THROW_ON_ERROR));

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/get-jobs')
            ->willReturn($expectedResponse);

        $result = $this->api->getJobs();

        $this->assertEmpty($result);
    }
}
