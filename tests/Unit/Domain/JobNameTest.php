<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\JobName;
use DjThossi\ErgosoftSdk\Exception\InvalidJobNameException;
use PHPUnit\Framework\TestCase;

final class JobNameTest extends TestCase
{
    public function testValidJobName(): void
    {
        $jobName = new JobName('Test Job');
        $this->assertSame('Test Job', $jobName->value);
    }

    public function testInvalidJobNameThrowsException(): void
    {
        $this->expectException(InvalidJobNameException::class);
        $this->expectExceptionMessage('The jobName must not be empty.');

        new JobName('');
    }

    public function testEmptyStringWithWhitespaceThrowsException(): void
    {
        $this->expectException(InvalidJobNameException::class);
        $this->expectExceptionMessage('The jobName must not be empty.');

        new JobName('   ');
    }
}
