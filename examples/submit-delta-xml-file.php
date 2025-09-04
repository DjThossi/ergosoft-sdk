<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\Domain\HotFile;
use DjThossi\ErgosoftSdk\ErgosoftFactory;
use DjThossi\ErgosoftSdk\SimpleConfiguration;
use DjThossi\ErgosoftSdk\Domain\BaseUrl;

// Initialize the Ergosoft API client with YOUR URL
$factory = new ErgosoftFactory(new SimpleConfiguration(new BaseUrl('https://YOUR_API_URL')));
$api = $factory->createSubmitDeltaXmlFileApi();

$xmlContent = '<HotFile><Job Name="Example"><Image FileName="E:\arrow.png"></Image></Job></HotFile>';
$hotFile = new HotFile($xmlContent);

try {
    $jobGuid = $api->submitDeltaXmlFile($hotFile);
    echo 'Submitted Job GUID: ' . $jobGuid->value . "\n";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
