<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\GetJobsApi;
use DjThossi\ErgosoftSdk\Http\Client;

class GetJobsApiTest extends ApiTestCase
{
    public function testGetJobs(): void
    {
        $clientMock = $this->createMock(Client::class);
        $clientMock->expects($this->once())
            ->method('get')
            ->with('/Trickle/get-jobs')
            ->willReturn($this->createResponseMock(200, [], $this->getSampleJobsJson()));

        $api = new GetJobsApi($clientMock);
        $jobs = $api->getJobs();

        $this->assertCount(2, $jobs);
        $this->assertEquals('job-guid-1', $jobs[0]->getJobGuid());
        $this->assertEquals('12345', $jobs[0]->getJobId());
        $this->assertEquals('Test Job 1', $jobs[0]->getJobName());
        $this->assertEquals('RUNNING', $jobs[0]->getJobStatus());
        $this->assertEquals('Job is running', $jobs[0]->getJobStatusDescription());
        $this->assertEquals(1, $jobs[0]->getCopies());
        $this->assertEquals('2023-01-01T12:00:00Z', $jobs[0]->getTimeCreated()->format('Y-m-d\TH:i:s\Z'));
        $this->assertEquals(100, $jobs[0]->getJobWidthMm());
        $this->assertEquals(200, $jobs[0]->getJobLengthMm());
        $this->assertEquals(100, $jobs[0]->getMediaWidthMm());
        $this->assertEquals(200, $jobs[0]->getMediaLengthMm());
        $this->assertEquals(1, $jobs[0]->getCopiesPrinted());
        $this->assertEquals(10, $jobs[0]->getPrintSecElapsed());
        $this->assertEquals(20, $jobs[0]->getPrintSecRemaining());
        $this->assertEquals('2023-01-01T12:30:00Z', $jobs[0]->getTimePrinted()->format('Y-m-d\TH:i:s\Z'));
        $this->assertEquals(0, $jobs[0]->getCopiesPrintedBefore());
        $this->assertEquals('PRINT_ENV', $jobs[0]->getPrintEnv());
        $this->assertEquals('admin', $jobs[0]->getOwner());
        $this->assertEquals('printer-1', $jobs[0]->getPrinterId());
        $this->assertEquals('vinyl', $jobs[0]->getMediaType());
        $this->assertEquals('1.0', $jobs[0]->getPpVersion());
        $this->assertEquals('Customer Info', $jobs[0]->getCustomerInfo());
        $this->assertEquals('Pre-Ripped Info', $jobs[0]->getPreRippedInfo());
        $this->assertEquals('Journal', $jobs[0]->getJournal());
    }

    private function getSampleJobsJson(): string
    {
        return '[
            {
                "jobGuid": "job-guid-1",
                "jobId": "12345",
                "jobName": "Test Job 1",
                "jobStatus": "RUNNING",
                "jobStatusDescription": "Job is running",
                "copies": 1,
                "timeCreated": "2023-01-01T12:00:00Z",
                "jobWidthMm": 100,
                "jobLengthMm": 200,
                "mediaWidthMm": 100,
                "mediaLengthMm": 200,
                "copiesPrinted": 1,
                "printSecElapsed": 10,
                "printSecRemaining": 20,
                "timePrinted": "2023-01-01T12:30:00Z",
                "copiesPrintedBefore": 0,
                "printEnv": "PRINT_ENV",
                "owner": "admin",
                "printerId": "printer-1",
                "mediaType": "vinyl",
                "ppVersion": "1.0",
                "customerInfo": "Customer Info",
                "preRippedInfo": "Pre-Ripped Info",
                "journal": "Journal"
            },
            {
                "jobGuid": "job-guid-2",
                "jobId": "67890",
                "jobName": "Test Job 2",
                "jobStatus": "COMPLETED",
                "jobStatusDescription": "Job is completed",
                "copies": 2,
                "timeCreated": "2023-01-02T12:00:00Z",
                "jobWidthMm": 150,
                "jobLengthMm": 250,
                "mediaWidthMm": 150,
                "mediaLengthMm": 250,
                "copiesPrinted": 2,
                "printSecElapsed": 15,
                "printSecRemaining": 0,
                "timePrinted": "2023-01-02T12:45:00Z",
                "copiesPrintedBefore": 0,
                "printEnv": "PRINT_ENV",
                "owner": "admin",
                "printerId": "printer-1",
                "mediaType": "vinyl",
                "ppVersion": "1.0",
                "customerInfo": "Customer Info",
                "preRippedInfo": "Pre-Ripped Info",
                "journal": "Journal"
            }
        ]';
    }
}
