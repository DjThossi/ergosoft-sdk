<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidRequestTimeoutException;

final readonly class RequestTimeout
{
    public function __construct(
        public int $seconds
    ) {
        if ($this->seconds < 0) {
            throw new InvalidRequestTimeoutException('RequestTimeout must be greater than or equals 0 seconds');
        }
    }
}
