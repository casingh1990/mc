<?php

namespace Amit\Mc;

use Amit\Mc\Parsers\StringParser;

class Parser
{
    /**
     * Parses one Md line into HTML
     */
    public function parseLine(string $line)
    {
        return $this->getParser($line)->process($line);
    }

    protected function getParser(string $line): ConversionInterface
    {
        if (Header::is($line)) {
            return new Header();
        }

        return new DefaultProcessor();
    }
}