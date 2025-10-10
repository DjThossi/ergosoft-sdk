<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidJobStatusException;

readonly class JobStatus
{
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

    private function ensure(string $value): void
    {
        if (trim($value) === '') {
            throw new InvalidJobStatusException('The jobStatus must not be empty.');
        }
    }
}
