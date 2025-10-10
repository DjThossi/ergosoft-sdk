<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Api;

use DjThossi\ErgosoftSdk\Domain\HotFile;
use DjThossi\ErgosoftSdk\Domain\JobGuid;
use DjThossi\ErgosoftSdk\Domain\StatusCode;
use DjThossi\ErgosoftSdk\Domain\SubmitDeltaXmlFileResponse;
use DjThossi\ErgosoftSdk\Domain\SubmitDeltaXmlFileResponseBody;
use DjThossi\ErgosoftSdk\Http\Client;

use const JSON_THROW_ON_ERROR;

readonly class SubmitDeltaXmlFileApi
{
    private const string ENDPOINT = '/Trickle/submit-delta-xml-file';

    public function __construct(
        private Client $client,
    ) {
    }

    public function submitDeltaXmlFile(HotFile $hotFile): SubmitDeltaXmlFileResponse
    {
        $jsonContent = json_encode($hotFile->value, JSON_THROW_ON_ERROR);
        $response = $this->client->post(self::ENDPOINT, $jsonContent);
        $responseBody = (string) $response->getBody();
        $jobGuidString = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);

        return new SubmitDeltaXmlFileResponse(
            new StatusCode($response->getStatusCode()),
            new JobGuid($jobGuidString),
            new SubmitDeltaXmlFileResponseBody($responseBody)
        );
    }
}
