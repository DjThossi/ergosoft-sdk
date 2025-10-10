<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use DjThossi\ErgosoftSdk\SimpleErgosoftConfiguration;

// Initialize the Ergosoft API client with YOUR URL
$configuration = new SimpleErgosoftConfiguration(new BaseUrl('https://YOUR_API_URL'));
$factory = new ErgosoftFactory($configuration);
// Replace this with a valid job GUID
$jobGuid = new JobGuid('YOUR_JOB_GUID');

$api = $factory->createGetJobByGuidApi();

try {
    $response = $api->getJobByGuid($jobGuid);
    echo "Status code: {$response->statusCode->value}\n";
    echo "-----------------------------------\n";

    $job = $response->job;

    // Display job details
    echo "Job Details:\n";
    echo 'Job ID: ' . $job->getJobId()->value . "\n";
    echo 'Name: ' . ($job->getJobName()?->value ?? 'N/A') . "\n";
    echo 'Status: ' . $job->getJobStatus()->value . "\n";
    echo 'Status Description: ' . $job->getJobStatusDescription() . "\n";
    echo 'Created At: ' . ($job->getTimeCreated()?->format('Y-m-d H:i:s') ?? 'Not given') . "\n";
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
