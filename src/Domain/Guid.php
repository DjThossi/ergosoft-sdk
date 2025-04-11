<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidGuidException;

readonly class Guid
{
    public function __construct(
        public string $value,
    ) {
        $this->ensure();
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    private function ensure(): void
    {
        if (!$this->isValid($this->value)) {
            throw new InvalidGuidException($this->value);
        }
    }

    private function isValid(string $guid): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $guid) === 1;
    }
}
