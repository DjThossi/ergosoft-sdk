<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

readonly class StatusCode
{
    public function __construct(
        public int $value,
    ) {
    }

    public function isSuccessful(): bool
    {
        return $this->value >= 200 && $this->value < 300;
    }

    public function isOk(): bool
    {
        return $this->value === 200;
    }

    public function isNoContent(): bool
    {
        return $this->value === 204;
    }

    public function isBadRequest(): bool
    {
        return $this->value === 400;
    }

    public function isForbidden(): bool
    {
        return $this->value === 403;
    }

    public function isNotFound(): bool
    {
        return $this->value === 404;
    }
}
