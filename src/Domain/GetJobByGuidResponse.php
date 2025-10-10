<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

readonly class GetJobByGuidResponse
{
    public function __construct(
        public StatusCode $statusCode,
        public Job $job,
        public GetJobByGuidResponseBody $responseBody,
    ) {
    }
}
