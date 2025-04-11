<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\ErgosoftFactory;

// Initialize the Ergosoft API client with YOUR URL
$factory = new ErgosoftFactory('https://YOUR_API_URL');
// Replace this with a valid job GUID
$jobGuid = new JobGuid('YOUR_JOB_GUID');

$api = $factory->createGetJobByGuidApi();

try {
    $job = $api->getJobByGuid($jobGuid);

    // Display job details
    echo "Job Details:\n";
    echo 'Job ID: ' . $job->getJobId()->value . "\n";
    echo 'Name: ' . $job->getJobName()->value . "\n";
    echo 'Status: ' . $job->getJobStatus() . "\n";
    echo 'Status Description: ' . $job->getJobStatusDescription() . "\n";
    echo 'Created At: ' . $job->getTimeCreated()->format('Y-m-d H:i:s') . "\n";
    if ($job->getTimePrinted()) {
        echo 'Printed At: ' . $job->getTimePrinted()->format('Y-m-d H:i:s') . "\n";
    }
    echo 'Copies: ' . $job->getCopies() . "\n";
    echo 'Copies Printed: ' . $job->getCopiesPrinted() . "\n";
    echo 'Media Type: ' . $job->getMediaType() . "\n";
    echo 'Printer ID: ' . $job->getPrinterId() . "\n";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
