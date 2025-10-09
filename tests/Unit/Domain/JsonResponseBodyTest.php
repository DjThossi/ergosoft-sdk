<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\JsonResponseBody;
use JsonException;
use PHPUnit\Framework\TestCase;

class JsonResponseBodyTest extends TestCase
{
    public function testConstructorWithValidJson(): void
    {
        $jsonString = '{"message": "test"}';
        $responseBody = new JsonResponseBody($jsonString);
        $this->assertEquals($jsonString, $responseBody->value);
    }

    public function testIsValidJsonWithValidJson(): void
    {
        $jsonString = '{"message": "test"}';
        $responseBody = new JsonResponseBody($jsonString);
        $this->assertTrue($responseBody->isValidJson());
    }

    public function testIsValidJsonWithInvalidJson(): void
    {
        $invalidJson = '{invalid json}';
        $responseBody = new JsonResponseBody($invalidJson);
        $this->assertFalse($responseBody->isValidJson());
    }

    public function testIsValidJsonWithEmptyString(): void
    {
        $responseBody = new JsonResponseBody('');
        $this->assertFalse($responseBody->isValidJson());
    }

    public function testIsValidJsonWithValidArray(): void
    {
        $jsonString = '[1, 2, 3]';
        $responseBody = new JsonResponseBody($jsonString);
        $this->assertTrue($responseBody->isValidJson());
    }

    public function testIsValidJsonWithValidNestedObject(): void
    {
        $jsonString = '{"data": {"message": "test", "code": 200}}';
        $responseBody = new JsonResponseBody($jsonString);
        $this->assertTrue($responseBody->isValidJson());
    }

    public function testGetDecodedJsonWithValidJson(): void
    {
        $jsonString = '{"message": "test", "code": 200}';
        $responseBody = new JsonResponseBody($jsonString);
        $decoded = $responseBody->getDecodedJson();
        
        $this->assertIsArray($decoded);
        $this->assertEquals('test', $decoded['message']);
        $this->assertEquals(200, $decoded['code']);
    }

    public function testGetDecodedJsonWithEmptyObject(): void
    {
        $jsonString = '{}';
        $responseBody = new JsonResponseBody($jsonString);
        $decoded = $responseBody->getDecodedJson();
        
        $this->assertIsArray($decoded);
        $this->assertEmpty($decoded);
    }

    public function testGetDecodedJsonWithArray(): void
    {
        $jsonString = '["item1", "item2", "item3"]';
        $responseBody = new JsonResponseBody($jsonString);
        $decoded = $responseBody->getDecodedJson();
        
        $this->assertIsArray($decoded);
        $this->assertEquals(['item1', 'item2', 'item3'], $decoded);
    }

    public function testGetDecodedJsonThrowsExceptionForInvalidJson(): void
    {
        $invalidJson = '{invalid json}';
        $responseBody = new JsonResponseBody($invalidJson);
        
        $this->expectException(JsonException::class);
        $responseBody->getDecodedJson();
    }

    public function testGetDecodedJsonWithNestedStructure(): void
    {
        $jsonString = '{"user": {"name": "John", "age": 30}, "items": [1, 2, 3]}';
        $responseBody = new JsonResponseBody($jsonString);
        $decoded = $responseBody->getDecodedJson();
        
        $this->assertIsArray($decoded);
        $this->assertEquals('John', $decoded['user']['name']);
        $this->assertEquals(30, $decoded['user']['age']);
        $this->assertEquals([1, 2, 3], $decoded['items']);
    }

    public function testIsValidJsonWithMalformedJson(): void
    {
        $malformedJson = '{"message": "test"';
        $responseBody = new JsonResponseBody($malformedJson);
        $this->assertFalse($responseBody->isValidJson());
    }

    public function testIsValidJsonWithPlainText(): void
    {
        $plainText = 'This is not JSON';
        $responseBody = new JsonResponseBody($plainText);
        $this->assertFalse($responseBody->isValidJson());
    }

    public function testGetDecodedJsonWithUnicodeCharacters(): void
    {
        $jsonString = '{"message": "Hëllö Wörld", "emoji": "😀"}';
        $responseBody = new JsonResponseBody($jsonString);
        $decoded = $responseBody->getDecodedJson();
        
        $this->assertEquals('Hëllö Wörld', $decoded['message']);
        $this->assertEquals('😀', $decoded['emoji']);
    }

    public function testInheritsFromStringResponseBody(): void
    {
        $jsonString = '{"message": "test"}';
        $responseBody = new JsonResponseBody($jsonString);
        
        // Test that it inherits the value property from StringResponseBody
        $this->assertEquals($jsonString, $responseBody->value);
    }

    public function testIsValidJsonWithNumericString(): void
    {
        $jsonString = '123';
        $responseBody = new JsonResponseBody($jsonString);
        $this->assertTrue($responseBody->isValidJson());
    }

    public function testIsValidJsonWithBooleanString(): void
    {
        $jsonString = 'true';
        $responseBody = new JsonResponseBody($jsonString);
        $this->assertTrue($responseBody->isValidJson());
    }

    public function testIsValidJsonWithNullString(): void
    {
        $jsonString = 'null';
        $responseBody = new JsonResponseBody($jsonString);
        $this->assertTrue($responseBody->isValidJson());
    }
}
