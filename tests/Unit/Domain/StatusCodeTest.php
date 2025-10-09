<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Tests\Unit\Domain;

use DjThossi\ErgosoftSdk\Domain\StatusCode;
use PHPUnit\Framework\TestCase;

class StatusCodeTest extends TestCase
{
    public function testConstructor(): void
    {
        $statusCode = new StatusCode(200);
        $this->assertEquals(200, $statusCode->value);
    }

    public function testIsOk(): void
    {
        $statusCode = new StatusCode(200);
        $this->assertTrue($statusCode->isOk());
    }

    public function testIsOkReturnsFalseForOtherCodes(): void
    {
        $statusCode = new StatusCode(204);
        $this->assertFalse($statusCode->isOk());
        
        $statusCode = new StatusCode(201);
        $this->assertFalse($statusCode->isOk());
        
        $statusCode = new StatusCode(400);
        $this->assertFalse($statusCode->isOk());
    }

    public function testIsNoContent(): void
    {
        $statusCode = new StatusCode(204);
        $this->assertTrue($statusCode->isNoContent());
    }

    public function testIsNoContentReturnsFalseForOtherCodes(): void
    {
        $statusCode = new StatusCode(200);
        $this->assertFalse($statusCode->isNoContent());
        
        $statusCode = new StatusCode(404);
        $this->assertFalse($statusCode->isNoContent());
    }

    public function testIsBadRequest(): void
    {
        $statusCode = new StatusCode(400);
        $this->assertTrue($statusCode->isBadRequest());
    }

    public function testIsBadRequestReturnsFalseForOtherCodes(): void
    {
        $statusCode = new StatusCode(200);
        $this->assertFalse($statusCode->isBadRequest());
        
        $statusCode = new StatusCode(404);
        $this->assertFalse($statusCode->isBadRequest());
    }

    public function testIsForbidden(): void
    {
        $statusCode = new StatusCode(403);
        $this->assertTrue($statusCode->isForbidden());
    }

    public function testIsForbiddenReturnsFalseForOtherCodes(): void
    {
        $statusCode = new StatusCode(200);
        $this->assertFalse($statusCode->isForbidden());
        
        $statusCode = new StatusCode(404);
        $this->assertFalse($statusCode->isForbidden());
    }

    public function testIsNotFound(): void
    {
        $statusCode = new StatusCode(404);
        $this->assertTrue($statusCode->isNotFound());
    }

    public function testIsNotFoundReturnsFalseForOtherCodes(): void
    {
        $statusCode = new StatusCode(200);
        $this->assertFalse($statusCode->isNotFound());
        
        $statusCode = new StatusCode(400);
        $this->assertFalse($statusCode->isNotFound());
    }

    public function testIsSuccessfulWith200(): void
    {
        $statusCode = new StatusCode(200);
        $this->assertTrue($statusCode->isSuccessful());
    }

    public function testIsSuccessfulWith204(): void
    {
        $statusCode = new StatusCode(204);
        $this->assertTrue($statusCode->isSuccessful());
    }

    public function testIsSuccessfulWith201(): void
    {
        $statusCode = new StatusCode(201);
        $this->assertTrue($statusCode->isSuccessful());
    }

    public function testIsSuccessfulWith299(): void
    {
        $statusCode = new StatusCode(299);
        $this->assertTrue($statusCode->isSuccessful());
    }

    public function testIsSuccessfulReturnsFalseFor199(): void
    {
        $statusCode = new StatusCode(199);
        $this->assertFalse($statusCode->isSuccessful());
    }

    public function testIsSuccessfulReturnsFalseFor300(): void
    {
        $statusCode = new StatusCode(300);
        $this->assertFalse($statusCode->isSuccessful());
    }

    public function testIsSuccessfulReturnsFalseFor400(): void
    {
        $statusCode = new StatusCode(400);
        $this->assertFalse($statusCode->isSuccessful());
    }

    public function testIsSuccessfulReturnsFalseFor404(): void
    {
        $statusCode = new StatusCode(404);
        $this->assertFalse($statusCode->isSuccessful());
    }

    public function testIsSuccessfulReturnsFalseFor500(): void
    {
        $statusCode = new StatusCode(500);
        $this->assertFalse($statusCode->isSuccessful());
    }

    public function testMultipleMethodCallsOnSameInstance(): void
    {
        $statusCode = new StatusCode(200);
        
        $this->assertTrue($statusCode->isSuccessful());
        $this->assertTrue($statusCode->isOk());
        $this->assertFalse($statusCode->isNoContent());
        $this->assertFalse($statusCode->isBadRequest());
        $this->assertFalse($statusCode->isForbidden());
        $this->assertFalse($statusCode->isNotFound());
    }

    public function testStatusCode404Properties(): void
    {
        $statusCode = new StatusCode(404);
        
        $this->assertFalse($statusCode->isSuccessful());
        $this->assertFalse($statusCode->isOk());
        $this->assertFalse($statusCode->isNoContent());
        $this->assertFalse($statusCode->isBadRequest());
        $this->assertFalse($statusCode->isForbidden());
        $this->assertTrue($statusCode->isNotFound());
    }
}
