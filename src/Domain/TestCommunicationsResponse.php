<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

readonly class TestCommunicationsResponse
{
    public function __construct(
        public StatusCode $statusCode,
        public TestCommunicationsResponseBody $responseBody,
    ) {
    }
}
