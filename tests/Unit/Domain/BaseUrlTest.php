<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Exception\InvalidBaseUrlException;
use PHPUnit\Framework\TestCase;

final class BaseUrlTest extends TestCase
{
    public function testValidBaseUrlNormalizesAndStoresValue(): void
    {
        $baseUrl = new BaseUrl('https://example.com/');
        $this->assertSame('https://example.com', $baseUrl->value);
    }

    public function testEmptyStringThrowsException(): void
    {
        $this->expectException(InvalidBaseUrlException::class);
        $this->expectExceptionMessage('BaseUrl must not be empty');
        new BaseUrl('');
    }

    public function testInvalidUrlThrowsException(): void
    {
        $this->expectException(InvalidBaseUrlException::class);
        $this->expectExceptionMessage('BaseUrl must be a valid URL');
        new BaseUrl('not-a-url');
    }
}
