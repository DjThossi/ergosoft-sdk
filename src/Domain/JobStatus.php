<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidJobStatusException;

readonly class JobStatus
{
    public const string SHORT_PRINTING = 'PRINTING';
    public const string SHORT_DONE = 'DONE';

    public function __construct(
        public string $value,
    ) {
        $this->ensure($value);
    }

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

    public function isDone(): bool
    {
        return $this->getShortVersion() === self::SHORT_DONE;
    }

    public function isPrinting(): bool
    {
        return $this->getShortVersion() === self::SHORT_PRINTING;
    }

    private function ensure(string $value): void
    {
        if (trim($value) === '') {
            throw new InvalidJobStatusException('The jobStatus must not be empty.');
        }
    }
}
