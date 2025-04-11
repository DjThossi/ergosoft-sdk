<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidJobIdException;

readonly class JobId
{
    public function __construct(
        public int $value,
    ) {
        $this->ensure();
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    private function ensure(): void
    {
        if ($this->value < 1) {
            throw new InvalidJobIdException($this->value);
        }
    }
}
