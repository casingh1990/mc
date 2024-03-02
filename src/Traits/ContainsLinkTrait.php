<?php

namespace Amit\Mc\Traits;

use Amit\Mc\Link;

trait ContainsLinkTrait
{
    protected function getOutputWithLink(string $input): string
    {
        $parts = preg_split(Link::PATTERN, $input);
        preg_match_all(Link::PATTERN, $input, $matches);
        $output = "";
        if (count($parts) === 1) {
            $p = trim($parts[0]);
            $output = $p;
        } else {
            preg_match_all(Link::PATTERN, $input, $matches);
            $link = new Link();
            $index = 0;
            foreach ($parts as $p) {
                $p = trim($p);
                $output .= $p;
                if (isset($matches[$index]) && Link::is($matches[$index][0])) {
                    $output .= " " . $link->process($matches[$index][0]) . " ";
                    $index++;
                }
            }
        }

        return $output;
    }
}