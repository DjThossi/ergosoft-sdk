<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\StringResponseBody;
use PHPUnit\Framework\TestCase;

class StringResponseBodyTest extends TestCase
{
    public function testConstructorWithNonEmptyString(): void
    {
        $responseBody = new StringResponseBody('test response');
        $this->assertEquals('test response', $responseBody->value);
    }

    public function testConstructorWithEmptyString(): void
    {
        $responseBody = new StringResponseBody('');
        $this->assertEquals('', $responseBody->value);
    }

    public function testConstructorWithJsonString(): void
    {
        $jsonString = '{"status":"success","message":"Job subscribed"}';
        $responseBody = new StringResponseBody($jsonString);
        $this->assertEquals($jsonString, $responseBody->value);
    }

    public function testConstructorWithMultilineString(): void
    {
        $multilineString = "Line 1\nLine 2\nLine 3";
        $responseBody = new StringResponseBody($multilineString);
        $this->assertEquals($multilineString, $responseBody->value);
    }

    public function testConstructorWithSpecialCharacters(): void
    {
        $specialString = 'Special chars: äöü ß € @ # $ % & * ()';
        $responseBody = new StringResponseBody($specialString);
        $this->assertEquals($specialString, $responseBody->value);
    }

    public function testConstructorWithNumericString(): void
    {
        $responseBody = new StringResponseBody('12345');
        $this->assertEquals('12345', $responseBody->value);
    }

    public function testConstructorWithWhitespace(): void
    {
        $responseBody = new StringResponseBody('   ');
        $this->assertEquals('   ', $responseBody->value);
    }

    public function testConstructorWithLongString(): void
    {
        $longString = str_repeat('a', 10000);
        $responseBody = new StringResponseBody($longString);
        $this->assertEquals($longString, $responseBody->value);
    }
}
