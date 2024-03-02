<?php

namespace Amit\Mc;

class DefaultProcessor implements ConversionInterface
{
    public static function is(string $input): bool
    {
        return preg_match('/^.?/$', $input);
    }

    public function process(string $input): string
    {
        $parts = preg_split(Link::PATTERN, $input);
        $output = "";
        if (count($parts) === 1) {
            $output = $parts[0];
        } else {
            preg_match_all(Link::PATTERN, $input, $matches);
            $link = new Link();
            foreach ($parts as $index => $p) {
                $output .= $p;
                if (isset($matches[$index])) {
                    $output .= $link->process((string)$matches[$index]);
                }
            }
        }

        return "<p>$output</p>";
    }
}