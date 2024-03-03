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
                $inputFile = __DIR__ . '/data/' . $f;
                $outputFile = __DIR__ . '/tmp.out'; 
                $input = fopen($inputFile, 'r');
                $parts = explode('.', $f);
                $output = fopen(__DIR__ . '/data/' . $parts[0] . '.html', 'r');

                $tmp = fopen($outputFile, 'w+');

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

    public function testConversionUsingFileInput()
    {
        $p = new Parser();
        $files = array_diff(scandir(__DIR__ . '/data/'), ['.', '..']);
        foreach($files as $f) {
            if (preg_match('/.?\.md/', $f)) {
                $inputFile = __DIR__ . '/data/' . $f;
                $outputFile = __DIR__ . '/tmp.out'; 
                $parts = explode('.', $f);
                $output = fopen(__DIR__ . '/data/' . $parts[0] . '.html', 'r');

                $input = fopen($inputFile, 'r');
                $tmp = fopen($outputFile, 'w+');

                $p->parseFile($input, $tmp);
                
                while ($parsed = fgets($tmp)) {
                    $expected = fgets($output);
                    $this->assertEquals($expected, $parsed);
                }

                fclose($output);
                fclose($tmp);
            }
        }
        $this->assertTrue(true);
    }

    public function testParseString()
    {
        $p = new Parser();
        $input = <<<Input
#### Another Header
###### Header 6

        This is a paragraph [with an inline link](http://google.com). Neat, eh?

Input;
        $expected = <<<Expected
<h4>Another Header</h4>
<h6>Header 6</h6>
<p>This is a paragraph <a href="http://google.com">with an inline link</a> . Neat, eh?</p>

Expected;
        $this->assertEquals($expected, $p->parseString($input));
    }

    public function testParseStringWithParagraph()
    {
        $p = new Parser();
        $input = <<<Input
#### Another Header
###### Header 6

        This is a paragraph [with an inline link](http://google.com). Neat, eh?
        And another line to this paragraph
Input;
        $expected = <<<Expected
<h4>Another Header</h4>
<h6>Header 6</h6>
<p>This is a paragraph <a href="http://google.com">with an inline link</a> . Neat, eh? And another line to this paragraph</p>

Expected;
        $this->assertEquals($expected, $p->parseString($input));
    }
}