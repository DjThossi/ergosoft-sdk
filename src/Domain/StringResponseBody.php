<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

readonly class StringResponseBody
{
    public function __construct(
        public string $value,
    ) {
    }
}
