<?php

namespace Amit\Mc;

class Parser
{
    public function parse($line) {
        
    }

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