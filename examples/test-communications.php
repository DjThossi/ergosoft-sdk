<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use DjThossi\ErgosoftSdk\SimpleErgosoftConfiguration;

// Initialize the Ergosoft API client with YOUR URL and optional timeout (defaults to 10 seconds)
$configuration = new SimpleErgosoftConfiguration(new BaseUrl('https://YOUR_API_URL'));
$factory = new ErgosoftFactory($configuration);
$api = $factory->createTestCommunicationsApi();

try {
    $response = $api->testCommunications();
    echo "Test communications request completed.\n";
    echo "Response Status Code: {$response->statusCode->value}\n";

    $message = $response->responseBody->getMessage();
    if ($message !== null) {
        echo "Message: {$message}\n";
    } else {
        echo "No message field in JSON response\n";
    }

    if ($response->statusCode->isSuccessful()) {
        echo "Success! Communications are working (200 OK)\n";
    } elseif ($response->statusCode->isServerError()) {
        echo "Server Error (500)\n";
    } elseif ($response->statusCode->isServiceUnavailable()) {
        echo "Service Unavailable (503)\n";
    } else {
        echo "Unexpected status code: {$response->statusCode->value}\n";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
