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
}
