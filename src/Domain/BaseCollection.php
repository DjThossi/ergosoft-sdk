<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use ArrayIterator;

use function count;

use Countable;
use IteratorAggregate;

abstract class BaseCollection implements Countable, IteratorAggregate
{
    protected array $elements = [];

    public function count(): int
    {
        return count($this->elements);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }

    protected function addElement($element): void
    {
        $this->elements[] = $element;
    }

    protected function addUniqueElement(string $key, $element): void
    {
        $this->elements[$key] = $element;
    }

    protected function addUniqueElementWithIntKey(int $key, $element): void
    {
        $this->elements[$key] = $element;
    }

    protected function keyExists(string $key): bool
    {
        return isset($this->elements[$key]);
    }

    protected function getElement(string $key): mixed
    {
        return $this->elements[$key] ?? null;
    }

    protected function removeUniqueElement(string $key): void
    {
        unset($this->elements[$key]);
    }
}
