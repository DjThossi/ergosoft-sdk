<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\ErgosoftFactory;

// Initialize the Ergosoft API client
$factory = new ErgosoftFactory('https://YOUR_API_URL');
$jobApi = $factory->getJobByGuidApi();

try {
    // Replace this with a valid job GUID
    $jobGuid = 'YOUR_JOB_GUID';
    $job = $jobApi->getJobByGuid($jobGuid);

    // Display job details
    echo "Job Details:\n";
    echo "Job ID: " . $job->getJobId() . "\n";
    echo "Name: " . $job->getJobName() . "\n";
    echo "Status: " . $job->getJobStatus() . "\n";
    echo "Status Description: " . $job->getJobStatusDescription() . "\n";
    echo "Created At: " . $job->getTimeCreated()->format('Y-m-d H:i:s') . "\n";
    if ($job->getTimePrinted()) {
        echo "Printed At: " . $job->getTimePrinted()->format('Y-m-d H:i:s') . "\n";
    }
    echo "Copies: " . $job->getCopies() . "\n";
    echo "Copies Printed: " . $job->getCopiesPrinted() . "\n";
    echo "Media Type: " . $job->getMediaType() . "\n";
    echo "Printer ID: " . $job->getPrinterId() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 