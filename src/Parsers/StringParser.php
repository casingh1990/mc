<?php

namespace Amit\Mc\Parsers;

class StringParser extends AbstractParser
{
    protected $lines;
    protected $linesIndex;
    public $output;

    function __construct(
        string $input
    ) {  
        $this->output = '';
        $this->linesIndex = 0;
        $this->lines = preg_split("/\r\n|\n|\r/", $input);
    }

    protected function next()
    {
        $val = $this->lines[$this->linesIndex] ?? null;
        $this->linesIndex++;

        /**
         * Little hack to avoid this being evaluated as the end of the input
         */
        if ($val === '') {
            $val = ' ';
        }

        return $val;
    }

    protected function output(string $out)
    {
        $this->output .= $out;
    }

    public function parse()
    {
        parent::parse();

        return $this->output;
    }
}