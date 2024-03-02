<?php

namespace Amit\Mc\Traits;

use Amit\Mc\Link;

trait ContainsLinkTrait
{
    protected function getOutputWithLink(string $input): string
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

        return $output;
    }
}