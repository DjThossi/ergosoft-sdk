<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Domain\Endpoint;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use DjThossi\ErgosoftSdk\SimpleErgosoftConfiguration;

// Initialize the Ergosoft API client with YOUR URL and optional timeout (defaults to 10 seconds)
$configuration = new SimpleErgosoftConfiguration(new BaseUrl('https://YOUR_API_URL'));
$factory = new ErgosoftFactory($configuration);
$api = $factory->createSubscribeJobStatusApi();

// Replace with the actual job GUID and webhook endpoint
$jobGuid = new JobGuid('12345678-1234-1234-1234-123456789abc');
$endpoint = new Endpoint('https://your-webhook-server.com/job-status-callback');
// The endpoint must accept a "PUT" request with this JSON: {'JobGuid': '12345678-1234-1234-1234-123456789abc', 'Status': 'WAITINGFORPRINT'}

try {
    $response = $api->subscribeJobStatus($jobGuid, $endpoint);
    echo "Subscribe job status request sent for GUID {$jobGuid->value}.\n";
    echo "Webhook endpoint: {$endpoint->value}\n";
    echo "Response Status Code: {$response->statusCode->value}\n";
    echo "Response Body: {$response->responseBody->value}\n\n";

    if ($response->statusCode->isSuccessful()) {
        echo 'Success! ';
        if ($response->statusCode->isOk()) {
            echo "Subscription successful (200 OK)\n";
        }
    } elseif ($response->statusCode->isBadRequest()) {
        echo "Bad Request (400) - Check the request parameters\n";
    } else {
        echo "Unexpected status code: {$response->statusCode->value}\n";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
