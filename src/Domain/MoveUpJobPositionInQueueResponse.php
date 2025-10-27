<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

readonly class MoveUpJobPositionInQueueResponse
{
    public function __construct(
        public StatusCode $statusCode,
        public MoveUpJobPositionInQueueResponseBody $responseBody,
    ) {
    }
}
