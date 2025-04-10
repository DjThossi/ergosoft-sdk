<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\ErgosoftFactory;

// Factory initialisieren
$factory = new ErgosoftFactory('http://192.168.1.2:50017');

// JobApi über die Factory abrufen
$jobApi = $factory->getJobsApi();

// Jobs abrufen
try {
    $jobs = $jobApi->getJobs();
    foreach ($jobs as $job) {
        echo 'Job ID: ' . $job->getJobId() . "\n";
        echo 'Job GUID: ' . $job->getJobGuid() . "\n";
        echo 'Name: ' . $job->getJobName() . "\n";
        echo 'Status: ' . $job->getJobStatus() . ' (' . $job->getJobStatusDescription() . ")\n";
        echo 'Copies: ' . $job->getCopies() . "\n";
        echo 'Created at: ' . $job->getTimeCreated()->format('Y-m-d H:i:s') . "\n";
        echo 'Job Width: ' . $job->getJobWidthMm() . " mm\n";
        echo 'Job Length: ' . $job->getJobLengthMm() . " mm\n";
        echo 'Media Width: ' . $job->getMediaWidthMm() . " mm\n";
        echo 'Media Length: ' . $job->getMediaLengthMm() . " mm\n";
        echo 'Copies Printed: ' . $job->getCopiesPrinted() . "\n";
        echo 'Print Time (elapsed): ' . $job->getPrintSecElapsed() . " seconds\n";
        echo 'Print Time (remaining): ' . $job->getPrintSecRemaining() . " seconds\n";

        if ($job->getTimePrinted()) {
            echo 'Printed at: ' . $job->getTimePrinted()->format('Y-m-d H:i:s') . "\n";
        } else {
            echo "Printed at: Not printed\n";
        }

        echo 'Copies Printed Before: ' . $job->getCopiesPrintedBefore() . "\n";
        echo 'Print Environment: ' . $job->getPrintEnv() . "\n";
        echo 'Owner: ' . $job->getOwner() . "\n";
        echo 'Printer ID: ' . $job->getPrinterId() . "\n";
        echo 'Media Type: ' . $job->getMediaType() . "\n";
        echo 'PP Version: ' . $job->getPpVersion() . "\n";
        echo 'Customer Info: ' . $job->getCustomerInfo() . "\n";
        echo 'Pre-Ripped Info: ' . $job->getPreRippedInfo() . "\n";
        echo 'Journal: ' . $job->getJournal() . "\n";
        echo "-----------------------------------\n";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
