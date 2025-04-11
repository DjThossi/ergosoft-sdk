<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Exception;

use InvalidArgumentException;

class InvalidJobIdException extends InvalidArgumentException
{
    public function __construct(int $jobId)
    {
        parent::__construct(\sprintf('"%s" is not a valid JobId', $jobId));
    }
}
