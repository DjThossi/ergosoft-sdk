<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\JobStatus;
use DjThossi\ErgosoftSdk\Exception\InvalidJobStatusException;
use PHPUnit\Framework\TestCase;

final class JobStatusTest extends TestCase
{
    public function testValidJobStatus(): void
    {
        $jobStatus = new JobStatus('RUNNING');
        $this->assertSame('RUNNING', $jobStatus->value);
    }

    public function testInvalidJobStatusThrowsException(): void
    {
        $this->expectException(InvalidJobStatusException::class);
        $this->expectExceptionMessage('The jobStatus must not be empty.');

        new JobStatus('');
    }

    public function testEmptyStringWithWhitespaceThrowsException(): void
    {
        $this->expectException(InvalidJobStatusException::class);
        $this->expectExceptionMessage('The jobStatus must not be empty.');

        new JobStatus('   ');
    }

    public function testGetShortVersionWithoutSpace(): void
    {
        $jobStatus = new JobStatus('RUNNING');
        $this->assertSame('RUNNING', $jobStatus->getShortVersion());
    }

    public function testGetShortVersionWithSpace(): void
    {
        $jobStatus = new JobStatus('RUNNING something');
        $this->assertSame('RUNNING', $jobStatus->getShortVersion());
    }

    public function testGetShortVersionWithMultipleSpaces(): void
    {
        $jobStatus = new JobStatus('RUNNING something else');
        $this->assertSame('RUNNING', $jobStatus->getShortVersion());
    }

    public function testGetShortVersionWithLeadingSpace(): void
    {
        $jobStatus = new JobStatus(' RUNNING');
        $this->assertSame('', $jobStatus->getShortVersion());
    }

    public function testGetShortVersionWithComplexStatus(): void
    {
        $jobStatus = new JobStatus('PRINTING 50%');
        $this->assertSame('PRINTING', $jobStatus->getShortVersion());
    }

    public function testIsDoneReturnsTrueForDoneStatus(): void
    {
        $jobStatus = new JobStatus(JobStatus::DONE);
        $this->assertTrue($jobStatus->isDone());
    }

    public function testIsDoneReturnsFalseForOtherStatus(): void
    {
        $jobStatus = new JobStatus(JobStatus::WAITING_FOR_SUBMISSION);
        $this->assertFalse($jobStatus->isDone());
    }

    public function testIsPrintingReturnsTrueForPrintingStatus(): void
    {
        $jobStatus = new JobStatus(JobStatus::PRINTING);
        $this->assertTrue($jobStatus->isPrinting());
    }

    public function testIsPrintingReturnsFalseForOtherStatus(): void
    {
        $jobStatus = new JobStatus(JobStatus::WAITING_FOR_SUBMISSION);
        $this->assertFalse($jobStatus->isPrinting());
    }

    public function testIsRippingReturnsTrueForRippingStatus(): void
    {
        $jobStatus = new JobStatus(JobStatus::RIPPING);
        $this->assertTrue($jobStatus->isRipping());
    }

    public function testIsRippingReturnsFalseForOtherStatus(): void
    {
        $jobStatus = new JobStatus(JobStatus::WAITING_FOR_SUBMISSION);
        $this->assertFalse($jobStatus->isRipping());
    }

    public function testIsWaitingForSubmissionReturnsTrueForWaitingForSubmissionStatus(): void
    {
        $jobStatus = new JobStatus(JobStatus::WAITING_FOR_SUBMISSION);
        $this->assertTrue($jobStatus->isWaitingForSubmission());
    }

    public function testIsWaitingForSubmissionReturnsFalseForOtherStatus(): void
    {
        $jobStatus = new JobStatus(JobStatus::DONE);
        $this->assertFalse($jobStatus->isWaitingForSubmission());
    }
}
