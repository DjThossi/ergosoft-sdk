<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Exception;

use RuntimeException;

use function sprintf;

class JobNotFoundException extends RuntimeException
{
    public function __construct(string $jobGuid)
    {
        parent::__construct(sprintf('Job with GUID "%s" not found', $jobGuid));
    }
}
