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

    /**
     * Use this to parse a full md file contents at a time
     */
    public function parseString(string $input): string
    {
        $lines = preg_split("/\r\n|\n|\r/", $input);
        $output = '';
        foreach ($lines as $line) {
            $output .= $this->parseLine($line);
        }

        return $output;
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