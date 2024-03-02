<?php

namespace Amit\Mc;

class Header implements ConversionInterface
{
    public static function is(string $input): bool
    {
        return preg_match('/^#? .?/', $input);
    }

    public function process(string $input): string
    {
        $i = 0;
        while($input[$i] === '#') {
            $i++;
        }

        return "<h$i>" . substr($input, $i) . "<h$i>";
    }
}