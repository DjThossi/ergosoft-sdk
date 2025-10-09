<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

readonly class UnsubscribeJobStatusResponse
{
    public function __construct(
        public StatusCode $statusCode,
        public StringResponseBody $responseBody,
    ) {
    }
}
