<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DateTimeImmutable;

readonly class Job
{
    public function __construct(
        private JobGuid $jobGuid,
        private JobId $jobId,
        private string $jobName,
        private string $jobStatus,
        private string $jobStatusDescription,
        private int $copies,
        private DateTimeImmutable $timeCreated,
        private int $jobWidthMm,
        private int $jobLengthMm,
        private int $mediaWidthMm,
        private int $mediaLengthMm,
        private int $copiesPrinted,
        private int $printSecElapsed,
        private int $printSecRemaining,
        private ?DateTimeImmutable $timePrinted,
        private int $copiesPrintedBefore,
        private string $printEnv,
        private string $owner,
        private string $printerId,
        private string $mediaType,
        private string $ppVersion,
        private string $customerInfo,
        private string $preRippedInfo,
        private string $journal,
    ) {
    }

    public function getJobGuid(): JobGuid
    {
        return $this->jobGuid;
    }

    public function getJobId(): JobId
    {
        return $this->jobId;
    }

    public function getJobName(): string
    {
        return $this->jobName;
    }

    public function getJobStatus(): string
    {
        return $this->jobStatus;
    }

    public function getJobStatusDescription(): string
    {
        return $this->jobStatusDescription;
    }

    public function getCopies(): int
    {
        return $this->copies;
    }

    public function getTimeCreated(): DateTimeImmutable
    {
        return $this->timeCreated;
    }

    public function getJobWidthMm(): int
    {
        return $this->jobWidthMm;
    }

    public function getJobLengthMm(): int
    {
        return $this->jobLengthMm;
    }

    public function getMediaWidthMm(): int
    {
        return $this->mediaWidthMm;
    }

    public function getMediaLengthMm(): int
    {
        return $this->mediaLengthMm;
    }

    public function getCopiesPrinted(): int
    {
        return $this->copiesPrinted;
    }

    public function getPrintSecElapsed(): int
    {
        return $this->printSecElapsed;
    }

    public function getPrintSecRemaining(): int
    {
        return $this->printSecRemaining;
    }

    public function getTimePrinted(): ?DateTimeImmutable
    {
        return $this->timePrinted;
    }

    public function getCopiesPrintedBefore(): int
    {
        return $this->copiesPrintedBefore;
    }

    public function getPrintEnv(): string
    {
        return $this->printEnv;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getPrinterId(): string
    {
        return $this->printerId;
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    public function getPpVersion(): string
    {
        return $this->ppVersion;
    }

    public function getCustomerInfo(): string
    {
        return $this->customerInfo;
    }

    public function getPreRippedInfo(): string
    {
        return $this->preRippedInfo;
    }

    public function getJournal(): string
    {
        return $this->journal;
    }
}
