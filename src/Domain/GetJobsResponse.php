<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

readonly class GetJobsResponse
{
    public function __construct(
        public StatusCode $statusCode,
        public JobCollection $jobs,
        public GetJobsResponseBody $responseBody,
    ) {
    }
}
