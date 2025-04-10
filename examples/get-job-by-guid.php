<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\ErgosoftFactory;

// Initialize the Ergosoft API client
$factory = new ErgosoftFactory('http://192.168.1.2:50017');
$jobApi = $factory->getJobByGuidApi();

try {
    // Replace this with a valid job GUID
    $jobGuid = 'b2589046-1589-40b8-a478-a61b692b326b';
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