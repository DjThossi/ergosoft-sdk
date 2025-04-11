<?php

declare(strict_types=1);

namespace DjThossi\ErgosoftSdk\Domain;

use DjThossi\ErgosoftSdk\Exception\InvalidHotFileException;

readonly class HotFile
{
    public function __construct(
        public string $value,
    ) {
        $this->ensureValidXml($value);
    }

    private function ensureValidXml(string $xml): void
    {
        if (empty($xml) || @simplexml_load_string($xml) === false) {
            throw new InvalidHotFileException('Invalid XML content provided.');
        }
    }
}
