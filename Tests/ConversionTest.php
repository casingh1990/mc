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
                $input = fopen(__DIR__ . '/data/' . $f, 'r');
                $parts = explode('.', $f);
                $output = fopen(__DIR__ . '/data/' . $parts[0] . '.html', 'r');

                $tmp = fopen(__DIR__ . '/tmp.out', 'w+');

                while ($line = fgets($input)) {
                    fwrite($tmp, $p->parseLine($line));
                }
                
                fseek($tmp, 0);
                while ($parsed = fgets($tmp)) {
                    $expected = fgets($output);
                    $this->assertEquals($expected, $parsed);
                }

                fclose($input);
                fclose($output);
                fclose($tmp);
            }
        }
        $this->assertTrue(true);
    }
}