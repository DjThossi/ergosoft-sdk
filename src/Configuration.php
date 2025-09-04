<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk;

use DjThossi\ErgosoftSdk\Domain\BaseUrl;
use DjThossi\ErgosoftSdk\Domain\RequestTimeout;

interface Configuration
{
    public function getBaseUrl(): BaseUrl;

    public function getRequestTimeout(): RequestTimeout;
}
