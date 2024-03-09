<?php

namespace Amit\Mc\Parsers;

class StreamParser extends AbstractParser
{

    function __construct(
        protected $inputFile,
        protected $outputFile
    ) { 
    }

    protected function next()
    {
        return fgets($this->inputFile);
    }

    protected function output(string $out)
    {
        fwrite($this->outputFile, $out);
    }
}