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
$api = $factory->createDeleteJobApi();

// Replace with the actual job GUID you want to delete
$jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');

try {
    $statusCode = $api->deleteJob($jobGuid);
    echo "Job with GUID {$jobGuid->value} has been deleted.\n";
    echo "Response Status Code: {$statusCode->value}\n";
    
    if ($statusCode->isSuccessful()) {
        echo "Success! ";
        if ($statusCode->isOk()) {
            echo "Job deleted (200 OK)\n";
        } elseif ($statusCode->isNoContent()) {
            echo "Job deleted (204 No Content)\n";
        }
    } elseif ($statusCode->isBadRequest()) {
        echo "Bad Request (400)\n";
    } elseif ($statusCode->isForbidden()) {
        echo "Forbidden (403)\n";
    } elseif ($statusCode->isNotFound()) {
        echo "Job Not Found (404)\n";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
