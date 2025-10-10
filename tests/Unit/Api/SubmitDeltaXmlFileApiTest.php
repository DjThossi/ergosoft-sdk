<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Api;

use DjThossi\ErgosoftSdk\Api\SubmitDeltaXmlFileApi;
use DjThossi\ErgosoftSdk\Domain\HotFile;
use DjThossi\ErgosoftSdk\Domain\SubmitDeltaXmlFileResponse;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Psr7\Response;

use const JSON_THROW_ON_ERROR;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SubmitDeltaXmlFileApiTest extends TestCase
{
    /**
     * @var Client&MockObject
     */
    private Client $client;
    private SubmitDeltaXmlFileApi $api;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->api = new SubmitDeltaXmlFileApi($this->client);
    }

    public function testSubmitDeltaXmlFile(): void
    {
        $xmlContent = '<HotFile><Job Name="Example"><Image FileName="C:\images\lizard.tif"></Image></Job></HotFile>';
        $hotFile = new HotFile($xmlContent);
        $expectedJobGuid = '4f1175eb-c6ca-4e9e-9edd-36babf2048e0';
        $expectedResponse = new Response(200, [], json_encode($expectedJobGuid, JSON_THROW_ON_ERROR));

        $this->client->expects($this->once())
            ->method('post')
            ->with('/Trickle/submit-delta-xml-file', json_encode($hotFile->value, JSON_THROW_ON_ERROR))
            ->willReturn($expectedResponse);

        $result = $this->api->submitDeltaXmlFile($hotFile);

        $this->assertInstanceOf(SubmitDeltaXmlFileResponse::class, $result);
        $this->assertSame(200, $result->statusCode->value);
        $this->assertSame($expectedJobGuid, $result->jobGuid->value);
        $this->assertTrue($result->responseBody->isValidJson());
    }
}
