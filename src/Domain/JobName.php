<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidJobNameException;

readonly class JobName
{
    public function __construct(
        public string $value,
    ) {
        $this->ensure($value);
    }

    private function ensure(string $value): void
    {
        if (trim($value) === '') {
            throw new InvalidJobNameException('The jobName must not be empty.');
        }
    }
}
