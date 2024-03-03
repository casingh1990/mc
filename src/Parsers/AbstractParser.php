<?php

namespace Amit\Mc\Parsers;

use Amit\Mc\DefaultProcessor;
use Amit\Mc\Header;
use Amit\Mc\Parser;

abstract class AbstractParser
{
    abstract protected function next();

    abstract protected function output(string $output);

    public function parse() {
        
        $parser = new Parser();
        $lastLineIsParagraph = false;
        $last = '';

        while($line = $this->next()) {
            $line = trim($line);

            if ($line === "" && $lastLineIsParagraph) {
                $this->output($parser->parseLine($last));
                $last = "";
            }

            if (Header::is($line)) {
                $this->output($parser->parseLine($line));
            } else {
                $last .= " $line";
            }

            $lastLineIsParagraph = DefaultProcessor::is($line) && !Header::is($line);
        }

        if ($last !== '') {
            $this->output($parser->parseLine($last));
        }
    }
}