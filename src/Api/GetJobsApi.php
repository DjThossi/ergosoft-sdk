<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Exception\GuzzleException;

class GetJobsApi
{
    private const string ENDPOINT = '/Trickle/get-jobs';

    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws GuzzleException
     *
     * @return Job[]
     */
    public function getJobs(): array
    {
        $response = $this->client->get(self::ENDPOINT);
        $data = json_decode((string) $response->getBody(), true);

        $jobs = [];
        if (\is_array($data)) {
            foreach ($data as $jobData) {
                $jobs[] = new Job(
                    $jobData['jobGuid'],
                    (string) $jobData['jobId'],
                    $jobData['jobName'],
                    $jobData['jobStatus'],
                    $jobData['jobStatusDescription'],
                    $jobData['copies'],
                    new \DateTimeImmutable($jobData['timeCreated']),
                    $jobData['jobWidthMm'],
                    $jobData['jobLengthMm'],
                    $jobData['mediaWidthMm'],
                    $jobData['mediaLengthMm'],
                    $jobData['copiesPrinted'],
                    $jobData['printSecElapsed'],
                    $jobData['printSecRemaining'],
                    isset($jobData['timePrinted']) && $jobData['timePrinted'] !== '1970-01-01T00:00:00Z'
                        ? new \DateTimeImmutable($jobData['timePrinted'])
                        : null,
                    $jobData['copiesPrintedBefore'],
                    $jobData['printEnv'],
                    $jobData['owner'],
                    $jobData['printerId'],
                    $jobData['mediaType'],
                    $jobData['ppVersion'],
                    $jobData['customerInfo'],
                    $jobData['preRippedInfo'],
                    $jobData['journal']
                );
            }
        }

        return $jobs;
    }
}
