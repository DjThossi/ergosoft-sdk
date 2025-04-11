<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DateTimeImmutable;
use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use PHPUnit\Framework\TestCase;

class JobTest extends TestCase
{
    public function testJobGetters(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $job = new Job(
            $jobGuid,
            '12345',
            'Test Job',
            'RUNNING',
            'Job is running',
            1,
            new DateTimeImmutable('2023-01-01T12:00:00Z'),
            100,
            200,
            100,
            200,
            1,
            10,
            20,
            new DateTimeImmutable('2023-01-01T12:30:00Z'),
            0,
            'PRINT_ENV',
            'admin',
            'printer-1',
            'vinyl',
            '1.0',
            'Customer Info',
            'Pre-Ripped Info',
            'Journal'
        );

        $this->assertSame($jobGuid, $job->getJobGuid());
        $this->assertEquals('12345', $job->getJobId());
        $this->assertEquals('Test Job', $job->getJobName());
        $this->assertEquals('RUNNING', $job->getJobStatus());
        $this->assertEquals('Job is running', $job->getJobStatusDescription());
        $this->assertEquals(1, $job->getCopies());
        $this->assertEquals('2023-01-01T12:00:00Z', $job->getTimeCreated()->format('Y-m-d\TH:i:s\Z'));
        $this->assertEquals(100, $job->getJobWidthMm());
        $this->assertEquals(200, $job->getJobLengthMm());
        $this->assertEquals(100, $job->getMediaWidthMm());
        $this->assertEquals(200, $job->getMediaLengthMm());
        $this->assertEquals(1, $job->getCopiesPrinted());
        $this->assertEquals(10, $job->getPrintSecElapsed());
        $this->assertEquals(20, $job->getPrintSecRemaining());
        $this->assertEquals('2023-01-01T12:30:00Z', $job->getTimePrinted()->format('Y-m-d\TH:i:s\Z'));
        $this->assertEquals(0, $job->getCopiesPrintedBefore());
        $this->assertEquals('PRINT_ENV', $job->getPrintEnv());
        $this->assertEquals('admin', $job->getOwner());
        $this->assertEquals('printer-1', $job->getPrinterId());
        $this->assertEquals('vinyl', $job->getMediaType());
        $this->assertEquals('1.0', $job->getPpVersion());
        $this->assertEquals('Customer Info', $job->getCustomerInfo());
        $this->assertEquals('Pre-Ripped Info', $job->getPreRippedInfo());
        $this->assertEquals('Journal', $job->getJournal());
    }

    public function testJobWithNullTimePrinted(): void
    {
        $job = new Job(
            new JobGuid('12345678-1234-1234-1234-123456789012'),
            '12345',
            'Test Job',
            'RUNNING',
            'Job is running',
            1,
            new DateTimeImmutable('2023-01-01T12:00:00Z'),
            100,
            200,
            100,
            200,
            1,
            10,
            20,
            null,
            0,
            'PRINT_ENV',
            'admin',
            'printer-1',
            'vinyl',
            '1.0',
            'Customer Info',
            'Pre-Ripped Info',
            'Journal'
        );

        $this->assertNull($job->getTimePrinted());
    }
}
