<?php

namespace Amit\Mc;

class Link implements ConversionInterface
{
    public const PATTERN = '/\[([a-zA-Z\s]+)\]\((.+)\)/';

    public static function is(string $input): bool
    {
        return preg_match(self::PATTERN, $input);
    }

    public function process(string $input): string
    {
        preg_match_all(self::PATTERN, $input, $parts);

        return <<<link
        <a href="{$parts[1]}">$parts[1]</a>
link;
    }
}