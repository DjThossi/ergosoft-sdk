<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Exception;

use InvalidArgumentException;

class InvalidEndpointException extends InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
