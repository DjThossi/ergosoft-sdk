<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk;

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Domain\RequestTimeout;

final readonly class SimpleErgosoftConfiguration implements ErgosoftConfiguration
{
    private BaseUrl $baseUrl;
    private RequestTimeout $requestTimeout;

    public function __construct(BaseUrl $baseUrl, ?RequestTimeout $requestTimeout = null)
    {
        $this->baseUrl = $baseUrl;
        $this->requestTimeout = $requestTimeout ?? new RequestTimeout(10.0);
    }

    public function getBaseUrl(): BaseUrl
    {
        return $this->baseUrl;
    }

    public function getRequestTimeout(): RequestTimeout
    {
        return $this->requestTimeout;
    }
}
