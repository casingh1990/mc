<?php

namespace Tests;

use Amit\Mc\Parser;
use Amit\Mc\Parsers\StreamParser;
use Amit\Mc\Parsers\StringParser;
use PHPUnit\Framework\TestCase;

/**
 * @uses Parser
 * (optional)@covers Parser
 */
class ConversionTest extends TestCase {
    public function testConversion()
    {
        $p = new Parser();
        $prefix = '/data_line_by_line/';
        $files = array_diff(scandir(__DIR__ . $prefix), ['.', '..']);
        foreach($files as $f) {
            if (preg_match('/.?\.md/', $f)) {
                $inputFile = __DIR__ . $prefix . $f;
                $outputFile = __DIR__ . '/tmp.out'; 
                $input = fopen($inputFile, 'r');
                $parts = explode('.', $f);
                $output = fopen(__DIR__ . $prefix . $parts[0] . '.html', 'r');

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
        $files = array_diff(scandir(__DIR__ . '/data/'), ['.', '..']);
        foreach($files as $f) {
            if (preg_match('/.?\.md/', $f)) {
                $inputFile = __DIR__ . '/data/' . $f;
                $outputFile = __DIR__ . '/tmp.out'; 
                $parts = explode('.', $f);
                $output = fopen(__DIR__ . '/data/' . $parts[0] . '.html', 'r');

                $input = fopen($inputFile, 'r');
                $tmp = fopen($outputFile, 'w+');

                $fileParser = new StreamParser($input, $tmp);
                $fileParser->parse($input, $tmp);
                
                fseek($tmp, 0);
                while ($parsed = fgets($tmp)) {
                    $expected = fgets($output);
                    $this->assertEquals($expected, $parsed);
                }

                fclose($output);
                fclose($tmp);
            }
        }
    }

    public function testParseString()
    {
        
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
        $p = new StringParser($input);
        $this->assertEquals($expected, $p->parse($input));
    }

    public function testParseStringWithParagraph()
    {
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
        $p = new StringParser($input);
        $this->assertEquals($expected, $p->parse($input));
    }

    /**
     * @dataProvider dataProviderSpecialCases
     */
    public function testSpecialCases($input, $expected)
    {
        $p = new StringParser($input);
        $this->assertEquals($expected, $p->parse($input));
    }

    public static function dataProviderSpecialCases()
    {
        return [
            'only link' => [
                'input' => '[with a link](http://yahoo.com)',
                'expected' => '<p> <a href="http://yahoo.com">with a link</a> </p>' . "\n"
            ]
        ];
    }
}