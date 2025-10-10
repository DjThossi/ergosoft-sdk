<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\TestCommunicationsResponseBody;
use PHPUnit\Framework\TestCase;

class TestCommunicationsResponseBodyTest extends TestCase
{
    public function testGetMessageWithValidMessage(): void
    {
        $jsonString = '{"message": "Ergosoft Communications is alive."}';
        $responseBody = new TestCommunicationsResponseBody($jsonString);

        $this->assertEquals('Ergosoft Communications is alive.', $responseBody->getMessage());
    }

    public function testGetMessageWithoutMessageField(): void
    {
        $jsonString = '{"status": "ok", "code": 200}';
        $responseBody = new TestCommunicationsResponseBody($jsonString);

        $this->assertNull($responseBody->getMessage());
    }

    public function testGetMessageWithInvalidJson(): void
    {
        $invalidJson = '{invalid json}';
        $responseBody = new TestCommunicationsResponseBody($invalidJson);

        $this->assertNull($responseBody->getMessage());
    }

    public function testGetMessageWithEmptyString(): void
    {
        $responseBody = new TestCommunicationsResponseBody('');

        $this->assertNull($responseBody->getMessage());
    }

    public function testGetMessageWithEmptyMessage(): void
    {
        $jsonString = '{"message": ""}';
        $responseBody = new TestCommunicationsResponseBody($jsonString);

        $this->assertEquals('', $responseBody->getMessage());
    }

    public function testGetMessageWithNullMessage(): void
    {
        $jsonString = '{"message": null}';
        $responseBody = new TestCommunicationsResponseBody($jsonString);

        $this->assertNull($responseBody->getMessage());
    }

    public function testGetMessageWithComplexJson(): void
    {
        $jsonString = '{"message": "Test message", "data": {"nested": "value"}, "code": 200}';
        $responseBody = new TestCommunicationsResponseBody($jsonString);

        $this->assertEquals('Test message', $responseBody->getMessage());
    }

    public function testGetMessageWithUnicodeCharacters(): void
    {
        $jsonString = '{"message": "Hëllö Wörld 😀"}';
        $responseBody = new TestCommunicationsResponseBody($jsonString);

        $this->assertEquals('Hëllö Wörld 😀', $responseBody->getMessage());
    }

    public function testInheritsIsValidJsonMethod(): void
    {
        $validJson = '{"message": "test"}';
        $responseBody = new TestCommunicationsResponseBody($validJson);

        $this->assertTrue($responseBody->isValidJson());
    }

    public function testInheritsIsValidJsonMethodWithInvalidJson(): void
    {
        $invalidJson = '{invalid}';
        $responseBody = new TestCommunicationsResponseBody($invalidJson);

        $this->assertFalse($responseBody->isValidJson());
    }

    public function testInheritsGetDecodedJsonMethod(): void
    {
        $jsonString = '{"message": "test", "code": 200}';
        $responseBody = new TestCommunicationsResponseBody($jsonString);
        $decoded = $responseBody->getDecodedJson();

        $this->assertIsArray($decoded);
        $this->assertEquals('test', $decoded['message']);
        $this->assertEquals(200, $decoded['code']);
    }

    public function testInheritsValueProperty(): void
    {
        $jsonString = '{"message": "test"}';
        $responseBody = new TestCommunicationsResponseBody($jsonString);

        $this->assertEquals($jsonString, $responseBody->value);
    }

    public function testGetMessageWithPlainText(): void
    {
        $plainText = 'This is not JSON';
        $responseBody = new TestCommunicationsResponseBody($plainText);

        $this->assertNull($responseBody->getMessage());
    }
}
