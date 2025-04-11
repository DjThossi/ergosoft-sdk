<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Exception;

class InvalidJobGuidException extends \InvalidArgumentException
{
    public function __construct(string $guid)
    {
        parent::__construct(\sprintf('"%s" is not a valid GUID', $guid));
    }
}
