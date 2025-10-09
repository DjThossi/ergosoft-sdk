<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

readonly class TestCommunicationsResponseBody extends JsonResponseBody
{
    public function getMessage(): ?string
    {
        if (!$this->isValidJson()) {
            return null;
        }

        $decoded = $this->getDecodedJson();
        return $decoded['message'] ?? null;
    }
}
