<?php

namespace Tests;

use Amit\Mc\DefaultProcessor;
use PHPUnit\Framework\TestCase;

/**
 * @uses Parser
 * (optional)@covers DefaultProcessor
 */
class DefaultProcessorUnitTest extends TestCase
{
    public function testIs()
    {
        $input = ' This is sample markdown for the [Mailchimp](https://www.mailchimp.com) homework assignment. ';

        $this->assertTrue(DefaultProcessor::is($input));
    }
}