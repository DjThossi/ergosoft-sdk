<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Exception\InvalidJobGuidException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

class JobGuidTest extends TestCase
{
    public function testValidGuid(): void
    {
        $guid = new JobGuid('123e4567-e89b-12d3-a456-426614174000');
        $this->assertSame('123e4567-e89b-12d3-a456-426614174000', $guid->value);
    }

    #[DataProvider('provideInvalidGuids')]
    public function testInvalidGuid(string $invalidGuid): void
    {
        $this->expectException(InvalidJobGuidException::class);
        $this->expectExceptionMessage(sprintf('"%s" is not a valid GUID', $invalidGuid));

        new JobGuid($invalidGuid);
    }

    public static function provideInvalidGuids(): array
    {
        return [
            'invalid-guid' => ['invalidGuid' => 'invalid-guid'],
            'too-short' => ['invalidGuid' => '123e4567-e89b-12d3-a456-42661417400'],
            'too-long' => ['invalidGuid' => '123e4567-e89b-12d3-a456-4266141740000'],
            'invalid-character' => ['invalidGuid' => '123e4567-e89b-12d3-a456-42661417400g'],
        ];
    }

    public function testEquals(): void
    {
        $guid1 = new JobGuid('123e4567-e89b-12d3-a456-426614174000');
        $guid2 = new JobGuid('123e4567-e89b-12d3-a456-426614174000');
        $guid3 = new JobGuid('987fcdeb-51a2-43d7-9c01-123456789abc');

        $this->assertTrue($guid1->equals($guid2));
        $this->assertFalse($guid1->equals($guid3));
    }
}
