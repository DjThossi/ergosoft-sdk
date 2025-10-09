<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use const JSON_THROW_ON_ERROR;

readonly class JsonResponseBody extends StringResponseBody
{
    public function isValidJson(): bool
    {
        if ($this->value === '') {
            return false;
        }

        return json_validate($this->value);
    }

    public function getDecodedJson(): array
    {
        return json_decode($this->value, true, 512, JSON_THROW_ON_ERROR);
    }
}
