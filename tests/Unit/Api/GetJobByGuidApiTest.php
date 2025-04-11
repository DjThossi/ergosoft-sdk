<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\GetJobByGuidApi;
use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Exception\JobNotFoundException;
use DjThossi\ErgosoftSdk\Http\Client;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;
use GuzzleHttp\Psr7\Response;

use const JSON_THROW_ON_ERROR;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

use function sprintf;

class GetJobByGuidApiTest extends TestCase
{
    /**
     * @var Client&MockObject
     */
    private Client $client;

    /**
     * @var JobMapper&MockObject
     */
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
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $responseJsonData = [
            JobMapper::FIELD_JOB_GUID => $jobGuid->value,
            JobMapper::FIELD_JOB_ID => '12345',
            JobMapper::FIELD_JOB_NAME => 'Test Job',
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
        ];
        $expectedResponse = new Response(200, [], json_encode($responseJsonData, JSON_THROW_ON_ERROR));

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/get-job-by-guid/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $job = $this->createMock(Job::class);

        $this->jobMapper->expects($this->once())
            ->method('mapFromArray')
            ->with($this->callback(fn ($data) => $data[JobMapper::FIELD_JOB_GUID] === $jobGuid->value))
            ->willReturn($job);

        $result = $this->api->getJobByGuid($jobGuid);

        $this->assertSame($job, $result);
    }

    public function testGetJobByGuidNotFound(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $expectedResponse = new Response(200, [], json_encode([], JSON_THROW_ON_ERROR));

        $this->client->expects($this->once())
            ->method('get')
            ->with('/Trickle/get-job-by-guid/' . $jobGuid->value)
            ->willReturn($expectedResponse);

        $this->jobMapper->expects($this->never())
            ->method('mapFromArray');

        $this->expectException(JobNotFoundException::class);
        $this->expectExceptionMessage(sprintf('Job with GUID "%s" not found', $jobGuid->value));

        $this->api->getJobByGuid($jobGuid);
    }
}
