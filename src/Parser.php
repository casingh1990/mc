<?php

namespace Amit\Mc;

class Parser
{
    /**
     * Use this method to process the given input stream into the given output stream
     * This is useful for large inputs
     * parseFile
     * @var $input input stream
     * @var $output output stream
     * @return void
     */
    public function parseFile($input, $output): void
    {
        while ($line = fgets($input)) {
            fwrite($output, $this->parseLine($line));
        }
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