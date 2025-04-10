<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

class Job
{
    public function __construct(
        private readonly string $jobGuid,
        private readonly string $jobId,
        private readonly string $jobName,
        private readonly string $jobStatus,
        private readonly string $jobStatusDescription,
        private readonly int $copies,
        private readonly \DateTimeImmutable $timeCreated,
        private readonly int $jobWidthMm,
        private readonly int $jobLengthMm,
        private readonly int $mediaWidthMm,
        private readonly int $mediaLengthMm,
        private readonly int $copiesPrinted,
        private readonly int $printSecElapsed,
        private readonly int $printSecRemaining,
        private readonly ?\DateTimeImmutable $timePrinted,
        private readonly int $copiesPrintedBefore,
        private readonly string $printEnv,
        private readonly string $owner,
        private readonly string $printerId,
        private readonly string $mediaType,
        private readonly string $ppVersion,
        private readonly string $customerInfo,
        private readonly string $preRippedInfo,
        private readonly string $journal,
    ) {
    }

    public function getJobGuid(): string
    {
        return $this->jobGuid;
    }

    public function getJobId(): string
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

    public function getTimeCreated(): \DateTimeImmutable
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

    public function getTimePrinted(): ?\DateTimeImmutable
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
