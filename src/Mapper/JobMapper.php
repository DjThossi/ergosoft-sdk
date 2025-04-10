<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Mapper;

use DjThossi\ErgosoftSdk\Domain\Job;
use DateTimeImmutable;

readonly class JobMapper
{
    public function mapFromArray(array $data): Job
    {
        $timePrinted = null;
        if (isset($data['timePrinted']) && $data['timePrinted'] !== '1970-01-01T00:00:00Z') {
            $timePrinted = new DateTimeImmutable($data['timePrinted']);
        }

        return new Job(
            $data['jobGuid'],
            (string) $data['jobId'],
            $data['jobName'],
            $data['jobStatus'],
            $data['jobStatusDescription'],
            $data['copies'],
            new DateTimeImmutable($data['timeCreated']),
            $data['jobWidthMm'],
            $data['jobLengthMm'],
            $data['mediaWidthMm'],
            $data['mediaLengthMm'],
            $data['copiesPrinted'],
            $data['printSecElapsed'],
            $data['printSecRemaining'],
            $timePrinted,
            $data['copiesPrintedBefore'],
            $data['printEnv'],
            $data['owner'],
            $data['printerId'],
            $data['mediaType'],
            $data['ppVersion'],
            $data['customerInfo'],
            $data['preRippedInfo'],
            $data['journal']
        );
    }
} 