<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidEndpointException;

use const FILTER_VALIDATE_URL;

readonly class Endpoint
{
    public function __construct(
        public string $value,
    ) {
        $this->ensure();
    }

    private function ensure(): void
    {
        if ($this->value === '') {
            throw new InvalidEndpointException('Endpoint must not be empty');
        }
        if (!filter_var($this->value, FILTER_VALIDATE_URL)) {
            throw new InvalidEndpointException('Endpoint must be a valid URL');
        }
    }
}
