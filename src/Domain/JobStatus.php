<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidJobStatusException;

readonly class JobStatus
{
    /* @deprecated use PRINTING instead */
    public const string SHORT_PRINTING = 'PRINTING';

    /* @deprecated use DONE instead */
    public const string SHORT_DONE = 'DONE';

    public const string WAITING_FOR_SUBMISSION = 'WAITINGFORSUBMISSION';
    public const string RIPPING = 'RIPPING';
    public const string PRINTING = 'PRINTING';
    public const string DONE = 'DONE';

    public function __construct(
        public string $value,
    ) {
        $this->ensure($value);
    }

    /* @deprecated use value instead */
    public function getShortVersion(): string
    {
        $stateShortVersion = $this->value;
        $spacePosition = strpos($stateShortVersion, ' ');

        return $spacePosition !== false ? substr(
            $stateShortVersion,
            0,
            $spacePosition
        ) : $stateShortVersion;
    }

    public function isWaitingForSubmission(): bool
    {
        return $this->value === self::WAITING_FOR_SUBMISSION;
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
