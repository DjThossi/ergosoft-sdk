<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Exception;

use InvalidArgumentException;

class MissingRequiredFieldsException extends InvalidArgumentException
{
    /**
     * @param string[] $missingFields
     */
    public function __construct(array $missingFields)
    {
        parent::__construct(\sprintf(
            'Missing required fields: %s',
            implode(', ', $missingFields)
        ));
    }
}
