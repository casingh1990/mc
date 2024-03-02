<?php

namespace Amit\Mc;

interface ConversionInterface
{
    public static function is(string $input): bool;
    public function process(string $input): string;
}