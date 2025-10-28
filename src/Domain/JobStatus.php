<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidJobStatusException;

readonly class JobStatus
{
    public const string WAITING_FOR_SUBMISSION = 'WAITINGFORSUBMISSION';
    public const string WAITING_FOR_RIP = 'WAITINGFORRIP';
    public const string RIPPING = 'RIPPING';
    public const string PRINTING = 'PRINTING';
    public const string DONE = 'DONE';

    public function __construct(
        public string $value,
    ) {
        $this->ensure($value);
    }

    public function isWaitingForSubmission(): bool
    {
        return $this->value === self::WAITING_FOR_SUBMISSION;
    }

    public function isWaitingForRip(): bool
    {
        return $this->value === self::WAITING_FOR_RIP;
    }

    public function isRipping(): bool
    {
        return $this->value === self::RIPPING;
    }

    public function isPrinting(): bool
    {
        return $this->value === self::PRINTING;
    }

    public function isDone(): bool
    {
        return $this->value === self::DONE;
    }

    private function ensure(string $value): void
    {
        if (trim($value) === '') {
            throw new InvalidJobStatusException('The jobStatus must not be empty.');
        }
    }
}
