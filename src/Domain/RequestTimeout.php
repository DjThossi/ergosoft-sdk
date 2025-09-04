<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidRequestTimeoutException;

final class RequestTimeout
{
    public readonly float $seconds;

    public function __construct(float $seconds)
    {
        if ($seconds <= 0) {
            throw new InvalidRequestTimeoutException('RequestTimeout must be greater than 0 seconds');
        }
        $this->seconds = $seconds;
    }
}
