<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Factory;

use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Http\Client;

class ErgosoftFactory
{
    private Client $client;

    public function __construct(string $baseUrl)
    {
        $this->client = new Client($baseUrl);
    }

    public function getJobsApi(): GetJobsApi
    {
        return new GetJobsApi($this->client);
    }
}
