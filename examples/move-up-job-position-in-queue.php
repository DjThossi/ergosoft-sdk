<?php

declare(strict_types=1);

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use DjThossi\ErgosoftSdk\SimpleErgosoftConfiguration;

require __DIR__ . '/../vendor/autoload.php';

// Initialize the Ergosoft API client with YOUR URL and optional timeout (defaults to 10 seconds)
$configuration = new SimpleErgosoftConfiguration(new BaseUrl('https://YOUR_API_URL'));
$factory = new ErgosoftFactory($configuration);
$api = $factory->createMoveUpJobPositionInQueueApi();

$jobGuidMoveUp = new JobGuid('8c680b65-b6a6-49ed-a757-e8d208c10906');
$jobGuidMoveDown = new JobGuid('f8d2b399-9809-45b3-be24-c19e9b71db6d');

$response = $api->moveUp($jobGuidMoveUp, $jobGuidMoveDown);

echo 'Status Code: ' . $response->statusCode->value . \PHP_EOL;
echo 'Response Body: ' . $response->responseBody->value . \PHP_EOL;
