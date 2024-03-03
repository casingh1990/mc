<?php

namespace Amit\Mc;

use Amit\Mc\Traits\ContainsLinkTrait;

class DefaultProcessor implements ConversionInterface
{
    use ContainsLinkTrait;

    public static function is(string $input): bool
    {
        return preg_match('/^.+$/', $input);
    }

    public function process(string $input): string
    {
        $output = $this->getOutputWithLink($input);
        if ($output) {
            return "<p>$output</p>\n";
        }
        return $output;
    }
}