<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;
use GuzzleHttp\Psr7\Response;

use const JSON_THROW_ON_ERROR;

use PHPUnit\Framework\TestCase;

class GetJobsApiTest extends TestCase
{
    /**
     * @var Client&\PHPUnit\Framework\MockObject\MockObject
     */
    private Client $client;

    /**
     * @var JobMapper&\PHPUnit\Framework\MockObject\MockObject
     */
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
                JobMapper::FIELD_JOB_GUID => 'test-guid-1',
                JobMapper::FIELD_JOB_ID => '12345',
                JobMapper::FIELD_JOB_NAME => 'Test Job 1',
                JobMapper::FIELD_JOB_STATUS => 'RUNNING',
                JobMapper::FIELD_JOB_STATUS_DESCRIPTION => 'Job is running',
                JobMapper::FIELD_COPIES => 1,
                JobMapper::FIELD_TIME_CREATED => '2023-01-01T12:00:00Z',
                JobMapper::FIELD_JOB_WIDTH_MM => 100,
                JobMapper::FIELD_JOB_LENGTH_MM => 200,
                JobMapper::FIELD_MEDIA_WIDTH_MM => 100,
                JobMapper::FIELD_MEDIA_LENGTH_MM => 200,
                JobMapper::FIELD_COPIES_PRINTED => 1,
                JobMapper::FIELD_PRINT_SEC_ELAPSED => 10,
                JobMapper::FIELD_PRINT_SEC_REMAINING => 20,
                JobMapper::FIELD_TIME_PRINTED => '2023-01-01T12:30:00Z',
                JobMapper::FIELD_COPIES_PRINTED_BEFORE => 0,
                JobMapper::FIELD_PRINT_ENV => 'PRINT_ENV',
                JobMapper::FIELD_OWNER => 'admin',
                JobMapper::FIELD_PRINTER_ID => 'printer-1',
                JobMapper::FIELD_MEDIA_TYPE => 'vinyl',
                JobMapper::FIELD_PP_VERSION => '1.0',
                JobMapper::FIELD_CUSTOMER_INFO => 'Customer Info',
                JobMapper::FIELD_PRE_RIPPED_INFO => 'Pre-Ripped Info',
                JobMapper::FIELD_JOURNAL => 'Journal',
            ],
            [
                JobMapper::FIELD_JOB_GUID => 'test-guid-2',
                JobMapper::FIELD_JOB_ID => '67890',
                JobMapper::FIELD_JOB_NAME => 'Test Job 2',
                JobMapper::FIELD_JOB_STATUS => 'DONE',
                JobMapper::FIELD_JOB_STATUS_DESCRIPTION => 'Job is done',
                JobMapper::FIELD_COPIES => 2,
                JobMapper::FIELD_TIME_CREATED => '2023-01-02T12:00:00Z',
                JobMapper::FIELD_JOB_WIDTH_MM => 150,
                JobMapper::FIELD_JOB_LENGTH_MM => 250,
                JobMapper::FIELD_MEDIA_WIDTH_MM => 150,
                JobMapper::FIELD_MEDIA_LENGTH_MM => 250,
                JobMapper::FIELD_COPIES_PRINTED => 2,
                JobMapper::FIELD_PRINT_SEC_ELAPSED => 15,
                JobMapper::FIELD_PRINT_SEC_REMAINING => 0,
                JobMapper::FIELD_TIME_PRINTED => '2023-01-02T12:45:00Z',
                JobMapper::FIELD_COPIES_PRINTED_BEFORE => 0,
                JobMapper::FIELD_PRINT_ENV => 'PRINT_ENV',
                JobMapper::FIELD_OWNER => 'admin',
                JobMapper::FIELD_PRINTER_ID => 'printer-2',
                JobMapper::FIELD_MEDIA_TYPE => 'paper',
                JobMapper::FIELD_PP_VERSION => '1.0',
                JobMapper::FIELD_CUSTOMER_INFO => 'Customer Info',
                JobMapper::FIELD_PRE_RIPPED_INFO => 'Pre-Ripped Info',
                JobMapper::FIELD_JOURNAL => 'Journal',
            ],
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
                if ($data[JobMapper::FIELD_JOB_GUID] === 'test-guid-1') {
                    return $job1;
                }
                if ($data[JobMapper::FIELD_JOB_GUID] === 'test-guid-2') {
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
