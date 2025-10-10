<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Mapper;

use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\JobId;
use DjThossi\ErgosoftSdk\Domain\JobName;
use DjThossi\ErgosoftSdk\Exception\MissingRequiredFieldsException;
use DjThossi\ErgosoftSdk\Mapper\JobMapper;
use PHPUnit\Framework\TestCase;

class JobMapperTest extends TestCase
{
    private JobMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new JobMapper();
    }

    public function testMapFromArray(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $jobId = new JobId(12345);
        $jobName = new JobName('Test Job 1');
        $data = [
            JobMapper::FIELD_JOB_GUID => $jobGuid->value,
            JobMapper::FIELD_JOB_ID => $jobId->value,
            JobMapper::FIELD_JOB_NAME => $jobName->value,
            JobMapper::FIELD_JOB_STATUS => 'RUNNING',
            JobMapper::FIELD_JOB_STATUS_DESCRIPTION => 'Job is running',
            JobMapper::FIELD_COPIES => 1,
            JobMapper::FIELD_TIME_CREATED => '2023-01-01T12:00:00Z',
            JobMapper::FIELD_JOB_WIDTH_MM => 100,
            JobMapper::FIELD_JOB_LENGTH_MM => 200,
            JobMapper::FIELD_MEDIA_WIDTH_MM => 100.1,
            JobMapper::FIELD_MEDIA_LENGTH_MM => 200.2,
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

        $job = $this->mapper->mapFromArray($data);

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($jobGuid, $job->getJobGuid());
        $this->assertEquals($jobId, $job->getJobId());
        $this->assertEquals($jobName, $job->getJobName());
        $this->assertSame('RUNNING', $job->getJobStatus()->value);
        $this->assertSame('Job is running', $job->getJobStatusDescription());
        $this->assertSame(1, $job->getCopies());
        $this->assertSame('2023-01-01T12:00:00Z', $job->getTimeCreated()->format('Y-m-d\TH:i:s\Z'));
        $this->assertSame(100, $job->getJobWidthMm());
        $this->assertSame(200, $job->getJobLengthMm());
        $this->assertSame(100.1, $job->getMediaWidthMm());
        $this->assertSame(200.2, $job->getMediaLengthMm());
        $this->assertSame(1, $job->getCopiesPrinted());
        $this->assertSame(10, $job->getPrintSecElapsed());
        $this->assertSame(20, $job->getPrintSecRemaining());
        $this->assertSame('2023-01-01T12:30:00Z', $job->getTimePrinted()->format('Y-m-d\TH:i:s\Z'));
        $this->assertSame(0, $job->getCopiesPrintedBefore());
        $this->assertSame('PRINT_ENV', $job->getPrintEnv());
        $this->assertSame('admin', $job->getOwner());
        $this->assertSame('printer-1', $job->getPrinterId());
        $this->assertSame('vinyl', $job->getMediaType());
        $this->assertSame('1.0', $job->getPpVersion());
        $this->assertSame('Customer Info', $job->getCustomerInfo());
        $this->assertSame('Pre-Ripped Info', $job->getPreRippedInfo());
        $this->assertSame('Journal', $job->getJournal());
    }

    public function testMapFromArrayWithTimePrinted1970(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $jobId = new JobId(12346);
        $jobName = new JobName('Test Job 2');

        $data = [
            JobMapper::FIELD_JOB_GUID => $jobGuid->value,
            JobMapper::FIELD_JOB_ID => $jobId->value,
            JobMapper::FIELD_JOB_NAME => $jobName->value,
            JobMapper::FIELD_JOB_STATUS => 'RUNNING',
            JobMapper::FIELD_JOB_STATUS_DESCRIPTION => 'Job is running',
            JobMapper::FIELD_COPIES => 1,
            JobMapper::FIELD_TIME_CREATED => '2023-01-01T12:00:00Z',
            JobMapper::FIELD_JOB_WIDTH_MM => 100,
            JobMapper::FIELD_JOB_LENGTH_MM => 200,
            JobMapper::FIELD_MEDIA_WIDTH_MM => 100.2,
            JobMapper::FIELD_MEDIA_LENGTH_MM => 200.3,
            JobMapper::FIELD_COPIES_PRINTED => 1,
            JobMapper::FIELD_PRINT_SEC_ELAPSED => 10,
            JobMapper::FIELD_PRINT_SEC_REMAINING => 20,
            JobMapper::FIELD_TIME_PRINTED => '1970-01-01T00:00:00Z',
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

        $job = $this->mapper->mapFromArray($data);

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($jobGuid, $job->getJobGuid());
        $this->assertEquals($jobId, $job->getJobId());
        $this->assertEquals($jobName, $job->getJobName());
        $this->assertSame('RUNNING', $job->getJobStatus()->value);
        $this->assertSame('Job is running', $job->getJobStatusDescription());
        $this->assertSame(1, $job->getCopies());
        $this->assertSame('2023-01-01T12:00:00Z', $job->getTimeCreated()->format('Y-m-d\TH:i:s\Z'));
        $this->assertSame(100, $job->getJobWidthMm());
        $this->assertSame(200, $job->getJobLengthMm());
        $this->assertSame(100.2, $job->getMediaWidthMm());
        $this->assertSame(200.3, $job->getMediaLengthMm());
        $this->assertSame(1, $job->getCopiesPrinted());
        $this->assertSame(10, $job->getPrintSecElapsed());
        $this->assertSame(20, $job->getPrintSecRemaining());
        $this->assertNull($job->getTimePrinted());
        $this->assertSame(0, $job->getCopiesPrintedBefore());
        $this->assertSame('PRINT_ENV', $job->getPrintEnv());
        $this->assertSame('admin', $job->getOwner());
        $this->assertSame('printer-1', $job->getPrinterId());
        $this->assertSame('vinyl', $job->getMediaType());
        $this->assertSame('1.0', $job->getPpVersion());
        $this->assertSame('Customer Info', $job->getCustomerInfo());
        $this->assertSame('Pre-Ripped Info', $job->getPreRippedInfo());
        $this->assertSame('Journal', $job->getJournal());
    }

    public function testMapFromArrayWithTimePrintedNull(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $jobId = new JobId(12347);
        $jobName = new JobName('Test Job 3');
        $data = [
            JobMapper::FIELD_JOB_GUID => $jobGuid->value,
            JobMapper::FIELD_JOB_ID => $jobId->value,
            JobMapper::FIELD_JOB_NAME => $jobName->value,
            JobMapper::FIELD_JOB_STATUS => 'RUNNING',
            JobMapper::FIELD_JOB_STATUS_DESCRIPTION => 'Job is running',
            JobMapper::FIELD_COPIES => 1,
            JobMapper::FIELD_TIME_CREATED => '2023-01-01T12:00:00Z',
            JobMapper::FIELD_JOB_WIDTH_MM => 100,
            JobMapper::FIELD_JOB_LENGTH_MM => 200,
            JobMapper::FIELD_MEDIA_WIDTH_MM => 100.4,
            JobMapper::FIELD_MEDIA_LENGTH_MM => 200.5,
            JobMapper::FIELD_COPIES_PRINTED => 1,
            JobMapper::FIELD_PRINT_SEC_ELAPSED => 10,
            JobMapper::FIELD_PRINT_SEC_REMAINING => 20,
            JobMapper::FIELD_TIME_PRINTED => null,
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

        $job = $this->mapper->mapFromArray($data);

        /* @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($jobGuid, $job->getJobGuid());
        $this->assertEquals($jobId, $job->getJobId());
        $this->assertEquals($jobName, $job->getJobName());
        $this->assertSame('RUNNING', $job->getJobStatus()->value);
        $this->assertSame('Job is running', $job->getJobStatusDescription());
        $this->assertSame(1, $job->getCopies());
        $this->assertSame('2023-01-01T12:00:00Z', $job->getTimeCreated()->format('Y-m-d\TH:i:s\Z'));
        $this->assertSame(100, $job->getJobWidthMm());
        $this->assertSame(200, $job->getJobLengthMm());
        $this->assertSame(100.4, $job->getMediaWidthMm());
        $this->assertSame(200.5, $job->getMediaLengthMm());
        $this->assertSame(1, $job->getCopiesPrinted());
        $this->assertSame(10, $job->getPrintSecElapsed());
        $this->assertSame(20, $job->getPrintSecRemaining());
        $this->assertNull($job->getTimePrinted());
        $this->assertSame(0, $job->getCopiesPrintedBefore());
        $this->assertSame('PRINT_ENV', $job->getPrintEnv());
        $this->assertSame('admin', $job->getOwner());
        $this->assertSame('printer-1', $job->getPrinterId());
        $this->assertSame('vinyl', $job->getMediaType());
        $this->assertSame('1.0', $job->getPpVersion());
        $this->assertSame('Customer Info', $job->getCustomerInfo());
        $this->assertSame('Pre-Ripped Info', $job->getPreRippedInfo());
        $this->assertSame('Journal', $job->getJournal());
    }

    public function testMapFromArrayWithMissingFields(): void
    {
        $data = [
            JobMapper::FIELD_JOB_GUID => 'test-guid-4',
            JobMapper::FIELD_JOB_ID => '12348',
            JobMapper::FIELD_JOB_NAME => 'Test Job 4',
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
            // JobMapper::FIELD_JOURNAL missing on purpose
        ];

        $this->expectException(MissingRequiredFieldsException::class);
        $this->expectExceptionMessage('Missing required fields: journal');

        $this->mapper->mapFromArray($data);
    }

    public function testMapFromArrayWithMultipleMissingFields(): void
    {
        $data = [
            JobMapper::FIELD_JOB_GUID => 'test-guid-5',
            JobMapper::FIELD_JOB_ID => '12349',
            JobMapper::FIELD_JOB_NAME => 'Test Job 5',
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
            // JobMapper::FIELD_PRE_RIPPED_INFO missing on purpose
            // JobMapper::FIELD_JOURNAL missing on purpose
        ];

        $this->expectException(MissingRequiredFieldsException::class);
        $this->expectExceptionMessage('Missing required fields: preRippedInfo, journal');

        $this->mapper->mapFromArray($data);
    }
}
