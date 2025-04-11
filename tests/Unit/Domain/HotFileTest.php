<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\HotFile;
use DjThossi\ErgosoftSdk\Exception\InvalidHotFileException;
use PHPUnit\Framework\TestCase;

final class HotFileTest extends TestCase
{
    public function testValidHotFile(): void
    {
        $xmlContent = '<root><element>value</element></root>';
        $hotFile = new HotFile($xmlContent);
        $this->assertSame($xmlContent, $hotFile->value);
    }

    public function testInvalidHotFileThrowsException(): void
    {
        $this->expectException(InvalidHotFileException::class);
        $this->expectExceptionMessage('Invalid XML content provided.');

        new HotFile('');
    }

    public function testMalformedXmlThrowsException(): void
    {
        $this->expectException(InvalidHotFileException::class);
        $this->expectExceptionMessage('Invalid XML content provided.');

        new HotFile('<root><element></root>');
    }
}
