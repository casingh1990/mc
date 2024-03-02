<?php

namespace Tests;

use Amit\Mc\Parser;
use PHPUnit\Framework\TestCase;


/**
 * @uses Parser
 * (optional)@covers Parser
 */
class ConversionTest extends TestCase {
    public function testConversion()
    {
        $p = new Parser();
        $files = array_diff(scandir(__DIR__ . '/data/'), ['.', '..']);
        foreach($files as $f) {
            if (preg_match('/.?\.md/', $f)) {
                $input = fopen(__DIR__ . '/' . $f, 'r');
                $parts = explode('.', $f);
                $output = fopen(__DIR__ . '/' . $parts[0] . '.html', 'r');
                $this->assertEquals($output, $p->parse($input));
            }
        }
        $this->assertTrue(true);
    }
}