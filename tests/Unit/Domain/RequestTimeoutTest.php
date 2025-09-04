<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\RequestTimeout;
use DjThossi\ErgosoftSdk\Exception\InvalidRequestTimeoutException;
use PHPUnit\Framework\TestCase;

final class RequestTimeoutTest extends TestCase
{
    public function testValidTimeoutStoresSeconds(): void
    {
        $timeout = new RequestTimeout(2.5);
        $this->assertSame(2.5, $timeout->seconds);
    }

    public function testZeroThrowsException(): void
    {
        $this->expectException(InvalidRequestTimeoutException::class);
        $this->expectExceptionMessage('RequestTimeout must be greater than 0 seconds');
        new RequestTimeout(0.0);
    }

    public function testNegativeThrowsException(): void
    {
        $this->expectException(InvalidRequestTimeoutException::class);
        $this->expectExceptionMessage('RequestTimeout must be greater than 0 seconds');
        new RequestTimeout(-1);
    }
}
