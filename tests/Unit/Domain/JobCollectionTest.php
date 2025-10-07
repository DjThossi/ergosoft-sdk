<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use ArrayIterator;
use DateTimeImmutable;
use DjThossi\ErgosoftSdk\Domain\Job;
use DjThossi\ErgosoftSdk\Domain\JobCollection;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\JobId;
use DjThossi\ErgosoftSdk\Domain\JobName;
use PHPUnit\Framework\TestCase;

class JobCollectionTest extends TestCase
{
    private JobCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new JobCollection();
    }

    public function testCountReturnsZeroForEmptyCollection(): void
    {
        $this->assertSame(0, $this->collection->count());
    }

    public function testAddJobToCollection(): void
    {
        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');

        $this->collection->add($job);

        $this->assertSame(1, $this->collection->count());
    }

    public function testAddMultipleJobsToCollection(): void
    {
        $job1 = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $job2 = $this->createJob('22345678-1234-1234-1234-123456789012', 2, 'Job 2');
        $job3 = $this->createJob('32345678-1234-1234-1234-123456789012', 3, 'Job 3');

        $this->collection->add($job1);
        $this->collection->add($job2);
        $this->collection->add($job3);

        $this->assertSame(3, $this->collection->count());
    }

    public function testAddJobWithSameGuidOverwritesExisting(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $job1 = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $job2 = $this->createJob('12345678-1234-1234-1234-123456789012', 2, 'Job 2');

        $this->collection->add($job1);
        $this->collection->add($job2);

        $this->assertSame(1, $this->collection->count());

        $retrievedJob = $this->collection->getByJobGuid($jobGuid);
        $this->assertNotNull($retrievedJob);
        $this->assertEquals(new JobId(2), $retrievedJob->getJobId());
        $this->assertEquals(new JobName('Job 2'), $retrievedJob->getJobName());
    }

    public function testGetByJobGuidReturnsCorrectJob(): void
    {
        $jobGuid1 = new JobGuid('12345678-1234-1234-1234-123456789012');
        $jobGuid2 = new JobGuid('22345678-1234-1234-1234-123456789012');

        $job1 = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $job2 = $this->createJob('22345678-1234-1234-1234-123456789012', 2, 'Job 2');

        $this->collection->add($job1);
        $this->collection->add($job2);

        $retrievedJob1 = $this->collection->getByJobGuid($jobGuid1);
        $this->assertNotNull($retrievedJob1);
        $this->assertEquals($job1, $retrievedJob1);
        $this->assertEquals($jobGuid1, $retrievedJob1->getJobGuid());

        $retrievedJob2 = $this->collection->getByJobGuid($jobGuid2);
        $this->assertNotNull($retrievedJob2);
        $this->assertEquals($job2, $retrievedJob2);
        $this->assertEquals($jobGuid2, $retrievedJob2->getJobGuid());
    }

    public function testGetByJobGuidReturnsNullForNonexistentJob(): void
    {
        $nonexistentGuid = new JobGuid('99999999-9999-9999-9999-999999999999');

        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $this->collection->add($job);

        $retrievedJob = $this->collection->getByJobGuid($nonexistentGuid);
        $this->assertNull($retrievedJob);
    }

    public function testGetByJobGuidReturnsNullForEmptyCollection(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');

        $retrievedJob = $this->collection->getByJobGuid($jobGuid);
        $this->assertNull($retrievedJob);
    }

    public function testGetIteratorReturnsArrayIterator(): void
    {
        $job1 = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $job2 = $this->createJob('22345678-1234-1234-1234-123456789012', 2, 'Job 2');

        $this->collection->add($job1);
        $this->collection->add($job2);

        $iterator = $this->collection->getIterator();

        $this->assertInstanceOf(ArrayIterator::class, $iterator);
        $this->assertCount(2, $iterator);
    }

    public function testIterationOverCollection(): void
    {
        $job1 = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $job2 = $this->createJob('22345678-1234-1234-1234-123456789012', 2, 'Job 2');
        $job3 = $this->createJob('32345678-1234-1234-1234-123456789012', 3, 'Job 3');

        $this->collection->add($job1);
        $this->collection->add($job2);
        $this->collection->add($job3);

        $jobs = [];
        /** @noinspection PhpLoopCanBeConvertedToArrayMapInspection */
        foreach ($this->collection as $key => $job) {
            $jobs[$key] = $job;
        }

        $this->assertCount(3, $jobs);
        $this->assertSame('12345678-1234-1234-1234-123456789012', array_keys($jobs)[0]);
        $this->assertSame('22345678-1234-1234-1234-123456789012', array_keys($jobs)[1]);
        $this->assertSame('32345678-1234-1234-1234-123456789012', array_keys($jobs)[2]);
    }

    public function testCollectionIsCountable(): void
    {
        $job1 = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $job2 = $this->createJob('22345678-1234-1234-1234-123456789012', 2, 'Job 2');

        $this->collection->add($job1);
        $this->collection->add($job2);

        $this->assertCount(2, $this->collection);
    }

    public function testHasByJobGuidReturnsTrueForExistingJob(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');

        $this->collection->add($job);

        $this->assertTrue($this->collection->hasByJobGuid($jobGuid));
    }

    public function testHasByJobGuidReturnsFalseForNonexistentJob(): void
    {
        $nonexistentGuid = new JobGuid('99999999-9999-9999-9999-999999999999');

        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $this->collection->add($job);

        $this->assertFalse($this->collection->hasByJobGuid($nonexistentGuid));
    }

    public function testHasByJobGuidReturnsFalseForEmptyCollection(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');

        $this->assertFalse($this->collection->hasByJobGuid($jobGuid));
    }

    public function testRemoveByJobGuidRemovesJob(): void
    {
        $jobGuid1 = new JobGuid('12345678-1234-1234-1234-123456789012');
        $jobGuid2 = new JobGuid('22345678-1234-1234-1234-123456789012');

        $job1 = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $job2 = $this->createJob('22345678-1234-1234-1234-123456789012', 2, 'Job 2');

        $this->collection->add($job1);
        $this->collection->add($job2);

        $this->assertSame(2, $this->collection->count());

        $this->collection->removeByJobGuid($jobGuid1);

        $this->assertSame(1, $this->collection->count());
        $this->assertFalse($this->collection->hasByJobGuid($jobGuid1));
        $this->assertTrue($this->collection->hasByJobGuid($jobGuid2));
    }

    public function testRemoveByJobGuidDoesNothingForNonexistentJob(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');
        $nonexistentGuid = new JobGuid('99999999-9999-9999-9999-999999999999');

        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $this->collection->add($job);

        $this->assertSame(1, $this->collection->count());

        $this->collection->removeByJobGuid($nonexistentGuid);

        $this->assertSame(1, $this->collection->count());
        $this->assertTrue($this->collection->hasByJobGuid($jobGuid));
    }

    public function testRemoveByJobGuidDoesNothingForEmptyCollection(): void
    {
        $jobGuid = new JobGuid('12345678-1234-1234-1234-123456789012');

        $this->assertSame(0, $this->collection->count());

        $this->collection->removeByJobGuid($jobGuid);

        $this->assertSame(0, $this->collection->count());
    }

    public function testGetJobGuidsNativeReturnsArrayOfGuidStrings(): void
    {
        $job1 = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');
        $job2 = $this->createJob('22345678-1234-1234-1234-123456789012', 2, 'Job 2');
        $job3 = $this->createJob('32345678-1234-1234-1234-123456789012', 3, 'Job 3');

        $this->collection->add($job1);
        $this->collection->add($job2);
        $this->collection->add($job3);

        $guids = $this->collection->getJobGuidsNative();

        $this->assertIsArray($guids);
        $this->assertCount(3, $guids);
        $this->assertSame(['12345678-1234-1234-1234-123456789012', '22345678-1234-1234-1234-123456789012', '32345678-1234-1234-1234-123456789012'], $guids);
    }

    public function testGetJobGuidsNativeReturnsEmptyArrayForEmptyCollection(): void
    {
        $guids = $this->collection->getJobGuidsNative();

        $this->assertIsArray($guids);
        $this->assertCount(0, $guids);
        $this->assertSame([], $guids);
    }

    public function testGetJobGuidsNativeReturnsSingleGuid(): void
    {
        $job = $this->createJob('12345678-1234-1234-1234-123456789012', 1, 'Job 1');

        $this->collection->add($job);

        $guids = $this->collection->getJobGuidsNative();

        $this->assertIsArray($guids);
        $this->assertCount(1, $guids);
        $this->assertSame(['12345678-1234-1234-1234-123456789012'], $guids);
    }

    private function createJob(string $guidValue, int $jobIdValue, string $jobNameValue): Job
    {
        return new Job(
            jobGuid: new JobGuid($guidValue),
            jobId: new JobId($jobIdValue),
            jobName: new JobName($jobNameValue),
            jobStatus: 'RUNNING',
            jobStatusDescription: 'Job is running',
            copies: 1,
            timeCreated: new DateTimeImmutable('2023-01-01T12:00:00Z'),
            jobWidthMm: 100,
            jobLengthMm: 200,
            mediaWidthMm: 100.0,
            mediaLengthMm: 200.0,
            copiesPrinted: 0,
            printSecElapsed: 0,
            printSecRemaining: 100,
            timePrinted: null,
            copiesPrintedBefore: 0,
            printEnv: 'PRINT_ENV',
            owner: 'admin',
            printerId: 'printer-1',
            mediaType: 'vinyl',
            ppVersion: '1.0',
            customerInfo: 'Customer Info',
            preRippedInfo: 'Pre-Ripped Info',
            journal: 'Journal',
        );
    }
}
