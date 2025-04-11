<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DjThossi\ErgosoftSdk\Domain\HotFile;
use DjThossi\ErgosoftSdk\ErgosoftFactory;

// Initialize the Ergosoft API client with YOUR URL
$factory = new ErgosoftFactory('http://192.168.1.2:50017');
$submitApi = $factory->getSubmitDeltaXmlFileApi();

$xmlContent = '<HotFile><Job Name="Example"><Image FileName="E:\arrow.png"></Image></Job></HotFile>';
$hotFile = new HotFile($xmlContent);

try {
    $jobGuid = $submitApi->submitDeltaXmlFile($hotFile);
    echo 'Submitted Job GUID: ' . $jobGuid->value . "\n";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
