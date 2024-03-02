<?php

namespace Amit\Mc;

use Amit\Mc\Traits\ContainsLinkTrait;

class Header implements ConversionInterface
{
    use ContainsLinkTrait;

    public static function is(string $input): bool
    {
        return preg_match('/^#+ .?/', $input);
    }

    public function process(string $input): string
    {
        $i = 0;
        while($input[$i] === '#') {
            $i++;
        }

        return "<h$i>" . $this->getOutputWithLink(substr($input, $i)) . "</h$i>\n";
    }
}