<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\JobId;
use DjThossi\ErgosoftSdk\Exception\InvalidJobIdException;
use PHPUnit\Framework\TestCase;

final class JobIdTest extends TestCase
{
    public function testValidJobId(): void
    {
        $jobId = new JobId(123);
        $this->assertSame(123, $jobId->value);
    }

    public function testInvalidJobIdThrowsException(): void
    {
        $this->expectException(InvalidJobIdException::class);
        new JobId(0);
    }

    public function testJobIdEquality(): void
    {
        $jobId1 = new JobId(123);
        $jobId2 = new JobId(123);
        $jobId3 = new JobId(456);

        $this->assertTrue($jobId1->equals($jobId2));
        $this->assertFalse($jobId1->equals($jobId3));
    }
}
