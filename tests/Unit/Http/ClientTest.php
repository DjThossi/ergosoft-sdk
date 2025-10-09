<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Http;

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Domain\RequestTimeout;
use DjThossi\ErgosoftSdk\Http\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ClientTest extends TestCase
{
    public function testGet(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '{"foo": "bar"}'),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient(['handler' => $handlerStack]);

        $client = new Client(new BaseUrl('https://api.ergosoft.de'), new RequestTimeout(5));
        $reflection = new ReflectionClass($client);
        $property = $reflection->getProperty('client');
        $property->setValue($client, $guzzleClient);

        $response = $client->get('/test');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"foo": "bar"}', (string) $response->getBody());
    }

    public function testPost(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '{"foo": "bar"}'),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient(['handler' => $handlerStack]);

        $client = new Client(new BaseUrl('https://api.ergosoft.de'), new RequestTimeout(10));
        $reflection = new ReflectionClass($client);
        $property = $reflection->getProperty('client');
        $property->setValue($client, $guzzleClient);

        $response = $client->post('/test', '{"data": "test"}');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"foo": "bar"}', (string) $response->getBody());
    }

    public function testPut(): void
    {
        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient(['handler' => $handlerStack]);

        $client = new Client(new BaseUrl('https://api.ergosoft.de'), new RequestTimeout(5));
        $reflection = new ReflectionClass($client);
        $property = $reflection->getProperty('client');
        $property->setValue($client, $guzzleClient);

        $response = $client->put('/test');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('', (string) $response->getBody());
    }

    public function testDelete(): void
    {
        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient(['handler' => $handlerStack]);

        $client = new Client(new BaseUrl('https://api.ergosoft.de'), new RequestTimeout(5));
        $reflection = new ReflectionClass($client);
        $property = $reflection->getProperty('client');
        $property->setValue($client, $guzzleClient);

        $response = $client->delete('/test');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('', (string) $response->getBody());
    }
}
