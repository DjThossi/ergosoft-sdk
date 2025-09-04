<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidBaseUrlException;

final class BaseUrl
{
    public readonly string $value;

    public function __construct(string $value)
    {
        $normalized = rtrim($value, '/');
        if ($normalized === '') {
            throw new InvalidBaseUrlException('BaseUrl must not be empty');
        }
        if (!filter_var($normalized, FILTER_VALIDATE_URL)) {
            throw new InvalidBaseUrlException('BaseUrl must be a valid URL');
        }
        $this->value = $normalized;
    }
}
