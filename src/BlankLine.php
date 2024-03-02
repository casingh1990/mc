<?php

namespace Amit\Mc;

class DefaultProcessor implements ConversionInterface
{
    public static function is(string $input): bool
    {
        return preg_match('/^\s?$/', $input);
    }

    public function process(string $input): string
    {
        return "";
    }
}