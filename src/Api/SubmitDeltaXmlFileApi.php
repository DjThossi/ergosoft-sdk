<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\HotFile;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Http\Client;

use const JSON_THROW_ON_ERROR;

readonly class SubmitDeltaXmlFileApi
{
    private const string ENDPOINT = '/Trickle/submit-delta-xml-file';

    public function __construct(
        private Client $client,
    ) {
    }

    public function submitDeltaXmlFile(HotFile $hotFile): JobGuid
    {
        $jsonContent = json_encode($hotFile->value, JSON_THROW_ON_ERROR);
        $response = $this->client->post(self::ENDPOINT, $jsonContent);
        $jobGuidString = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return new JobGuid($jobGuidString);
    }
}
