<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\BaseCollection;
use PHPUnit\Framework\TestCase;

class BaseCollectionTest extends TestCase
{
    private TestableCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new TestableCollection();
    }

    public function testCountReturnsZeroForEmptyCollection(): void
    {
        $this->assertSame(0, $this->collection->count());
    }

    public function testCountReturnsCorrectNumberOfElements(): void
    {
        $this->collection->addTestElement('item1');
        $this->collection->addTestElement('item2');
        $this->collection->addTestElement('item3');

        $this->assertSame(3, $this->collection->count());
    }

    public function testGetIteratorReturnsArrayIterator(): void
    {
        $this->collection->addTestElement('item1');
        $this->collection->addTestElement('item2');

        $iterator = $this->collection->getIterator();

        $this->assertInstanceOf(\ArrayIterator::class, $iterator);
        $this->assertSame(['item1', 'item2'], $iterator->getArrayCopy());
    }

    public function testGetIteratorIsEmptyForEmptyCollection(): void
    {
        $iterator = $this->collection->getIterator();

        $this->assertInstanceOf(\ArrayIterator::class, $iterator);
        $this->assertCount(0, $iterator);
    }

    public function testAddElement(): void
    {
        $this->collection->addTestElement('item1');
        $this->collection->addTestElement('item2');

        $this->assertSame(2, $this->collection->count());

        $elements = iterator_to_array($this->collection->getIterator());
        $this->assertSame(['item1', 'item2'], $elements);
    }

    public function testAddUniqueElement(): void
    {
        $this->collection->addTestUniqueElement('key1', 'value1');
        $this->collection->addTestUniqueElement('key2', 'value2');

        $this->assertSame(2, $this->collection->count());

        $elements = iterator_to_array($this->collection->getIterator());
        $this->assertSame(['key1' => 'value1', 'key2' => 'value2'], $elements);
    }

    public function testAddUniqueElementOverwritesExistingKey(): void
    {
        $this->collection->addTestUniqueElement('key1', 'value1');
        $this->collection->addTestUniqueElement('key1', 'value2');

        $this->assertSame(1, $this->collection->count());

        $elements = iterator_to_array($this->collection->getIterator());
        $this->assertSame(['key1' => 'value2'], $elements);
    }

    public function testAddUniqueElementWithIntKey(): void
    {
        $this->collection->addTestUniqueElementWithIntKey(1, 'value1');
        $this->collection->addTestUniqueElementWithIntKey(2, 'value2');

        $this->assertSame(2, $this->collection->count());

        $elements = iterator_to_array($this->collection->getIterator());
        $this->assertSame([1 => 'value1', 2 => 'value2'], $elements);
    }

    public function testAddUniqueElementWithIntKeyOverwritesExistingKey(): void
    {
        $this->collection->addTestUniqueElementWithIntKey(1, 'value1');
        $this->collection->addTestUniqueElementWithIntKey(1, 'value2');

        $this->assertSame(1, $this->collection->count());

        $elements = iterator_to_array($this->collection->getIterator());
        $this->assertSame([1 => 'value2'], $elements);
    }

    public function testKeyExists(): void
    {
        $this->collection->addTestUniqueElement('key1', 'value1');

        $this->assertTrue($this->collection->testKeyExists('key1'));
        $this->assertFalse($this->collection->testKeyExists('key2'));
    }

    public function testGetElement(): void
    {
        $this->collection->addTestUniqueElement('key1', 'value1');
        $this->collection->addTestUniqueElement('key2', 'value2');

        $this->assertSame('value1', $this->collection->testGetElement('key1'));
        $this->assertSame('value2', $this->collection->testGetElement('key2'));
        $this->assertNull($this->collection->testGetElement('nonexistent'));
    }

    public function testRemoveUniqueElement(): void
    {
        $this->collection->addTestUniqueElement('key1', 'value1');
        $this->collection->addTestUniqueElement('key2', 'value2');

        $this->assertSame(2, $this->collection->count());

        $this->collection->testRemoveUniqueElement('key1');

        $this->assertSame(1, $this->collection->count());
        $this->assertFalse($this->collection->testKeyExists('key1'));
        $this->assertTrue($this->collection->testKeyExists('key2'));
    }

    public function testRemoveNonexistentElement(): void
    {
        $this->collection->addTestUniqueElement('key1', 'value1');

        $this->collection->testRemoveUniqueElement('nonexistent');

        $this->assertSame(1, $this->collection->count());
        $this->assertTrue($this->collection->testKeyExists('key1'));
    }

    public function testIterationOverCollection(): void
    {
        $this->collection->addTestUniqueElement('key1', 'value1');
        $this->collection->addTestUniqueElement('key2', 'value2');
        $this->collection->addTestUniqueElement('key3', 'value3');

        $items = [];
        foreach ($this->collection as $key => $value) {
            $items[$key] = $value;
        }

        $this->assertSame(['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3'], $items);
    }
}

/**
 * Concrete implementation of BaseCollection for testing purposes
 */
class TestableCollection extends BaseCollection
{
    public function addTestElement($element): void
    {
        $this->addElement($element);
    }

    public function addTestUniqueElement(string $key, $element): void
    {
        $this->addUniqueElement($key, $element);
    }

    public function addTestUniqueElementWithIntKey(int $key, $element): void
    {
        $this->addUniqueElementWithIntKey($key, $element);
    }

    public function testKeyExists(string $key): bool
    {
        return $this->keyExists($key);
    }

    public function testGetElement(string $key): mixed
    {
        return $this->getElement($key);
    }

    public function testRemoveUniqueElement(string $key): void
    {
        $this->removeUniqueElement($key);
    }
}
