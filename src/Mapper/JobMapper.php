<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Mapper;

use DateTimeImmutable;
use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Exception\MissingRequiredFieldsException;

readonly class JobMapper
{
    public const string FIELD_JOB_GUID = 'jobGuid';
    public const string FIELD_JOB_ID = 'jobId';
    public const string FIELD_JOB_NAME = 'jobName';
    public const string FIELD_JOB_STATUS = 'jobStatus';
    public const string FIELD_JOB_STATUS_DESCRIPTION = 'jobStatusDescription';
    public const string FIELD_COPIES = 'copies';
    public const string FIELD_TIME_CREATED = 'timeCreated';
    public const string FIELD_JOB_WIDTH_MM = 'jobWidthMm';
    public const string FIELD_JOB_LENGTH_MM = 'jobLengthMm';
    public const string FIELD_MEDIA_WIDTH_MM = 'mediaWidthMm';
    public const string FIELD_MEDIA_LENGTH_MM = 'mediaLengthMm';
    public const string FIELD_COPIES_PRINTED = 'copiesPrinted';
    public const string FIELD_PRINT_SEC_ELAPSED = 'printSecElapsed';
    public const string FIELD_PRINT_SEC_REMAINING = 'printSecRemaining';
    public const string FIELD_TIME_PRINTED = 'timePrinted';
    public const string FIELD_COPIES_PRINTED_BEFORE = 'copiesPrintedBefore';
    public const string FIELD_PRINT_ENV = 'printEnv';
    public const string FIELD_OWNER = 'owner';
    public const string FIELD_PRINTER_ID = 'printerId';
    public const string FIELD_MEDIA_TYPE = 'mediaType';
    public const string FIELD_PP_VERSION = 'ppVersion';
    public const string FIELD_CUSTOMER_INFO = 'customerInfo';
    public const string FIELD_PRE_RIPPED_INFO = 'preRippedInfo';
    public const string FIELD_JOURNAL = 'journal';

    /**
     * @param array<string, mixed> $data
     */
    public function mapFromArray(array $data): Job
    {
        $this->ensureRequiredFields($data);

        $timePrinted = null;
        if (isset($data[self::FIELD_TIME_PRINTED]) && $data[self::FIELD_TIME_PRINTED] !== '1970-01-01T00:00:00Z') {
            $timePrinted = new DateTimeImmutable($data[self::FIELD_TIME_PRINTED]);
        }

        return new Job(
            new JobGuid($data[self::FIELD_JOB_GUID]),
            (string) $data[self::FIELD_JOB_ID],
            $data[self::FIELD_JOB_NAME],
            $data[self::FIELD_JOB_STATUS],
            $data[self::FIELD_JOB_STATUS_DESCRIPTION],
            $data[self::FIELD_COPIES],
            new DateTimeImmutable($data[self::FIELD_TIME_CREATED]),
            $data[self::FIELD_JOB_WIDTH_MM],
            $data[self::FIELD_JOB_LENGTH_MM],
            $data[self::FIELD_MEDIA_WIDTH_MM],
            $data[self::FIELD_MEDIA_LENGTH_MM],
            $data[self::FIELD_COPIES_PRINTED],
            $data[self::FIELD_PRINT_SEC_ELAPSED],
            $data[self::FIELD_PRINT_SEC_REMAINING],
            $timePrinted,
            $data[self::FIELD_COPIES_PRINTED_BEFORE],
            $data[self::FIELD_PRINT_ENV],
            $data[self::FIELD_OWNER],
            $data[self::FIELD_PRINTER_ID],
            $data[self::FIELD_MEDIA_TYPE],
            $data[self::FIELD_PP_VERSION],
            $data[self::FIELD_CUSTOMER_INFO],
            $data[self::FIELD_PRE_RIPPED_INFO],
            $data[self::FIELD_JOURNAL]
        );
    }

    /**
     * @param array<string, mixed> $data
     */
    private function ensureRequiredFields(array $data): void
    {
        $requiredFields = [
            self::FIELD_JOB_GUID,
            self::FIELD_JOB_ID,
            self::FIELD_JOB_NAME,
            self::FIELD_JOB_STATUS,
            self::FIELD_JOB_STATUS_DESCRIPTION,
            self::FIELD_COPIES,
            self::FIELD_TIME_CREATED,
            self::FIELD_JOB_WIDTH_MM,
            self::FIELD_JOB_LENGTH_MM,
            self::FIELD_MEDIA_WIDTH_MM,
            self::FIELD_MEDIA_LENGTH_MM,
            self::FIELD_COPIES_PRINTED,
            self::FIELD_PRINT_SEC_ELAPSED,
            self::FIELD_PRINT_SEC_REMAINING,
            self::FIELD_COPIES_PRINTED_BEFORE,
            self::FIELD_PRINT_ENV,
            self::FIELD_OWNER,
            self::FIELD_PRINTER_ID,
            self::FIELD_MEDIA_TYPE,
            self::FIELD_PP_VERSION,
            self::FIELD_CUSTOMER_INFO,
            self::FIELD_PRE_RIPPED_INFO,
            self::FIELD_JOURNAL,
        ];

        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            throw new MissingRequiredFieldsException($missingFields);
        }
    }
}
