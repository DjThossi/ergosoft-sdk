<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use DjThossi\ErgosoftSdk\SimpleErgosoftConfiguration;

// Initialize the Ergosoft API client with YOUR URL and optional timeout (defaults to 10 seconds)
$configuration = new SimpleErgosoftConfiguration(new BaseUrl('https://YOUR_API_URL'));
$factory = new ErgosoftFactory($configuration);
$api = $factory->createCancelRippingJobApi();

// Replace with the actual job GUID you want to cancel
$jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');

try {
    $statusCode = $api->cancelRippingJob($jobGuid);
    echo "Cancel ripping job request sent for GUID {$jobGuid->value}.\n";
    echo "Response Status Code: {$statusCode->value}\n";

    if ($statusCode->isSuccessful()) {
        echo 'Success! ';
        if ($statusCode->isOk()) {
            echo "Ripping job cancelled (200 OK)\n";
        }
    } elseif ($statusCode->isBadRequest()) {
        echo "Bad Request (400)\n";
    } elseif ($statusCode->isForbidden()) {
        echo "Forbidden (403)\n";
    } elseif ($statusCode->isNotFound()) {
        echo "Job Not Found (404)\n";
    } elseif ($statusCode->isConflict()) {
        echo "Conflict (409)\n";
    } elseif ($statusCode->isServerError()) {
        echo "Server Error (500)\n";
    } elseif ($statusCode->isServiceUnavailable()) {
        echo "Service Unavailable (503)\n";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
