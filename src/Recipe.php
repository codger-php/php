<?php

namespace Codger\Php;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;
use Codger\Generate;

abstract class Recipe extends Generate\Recipe
{
    public function __construct()
    {
        parent::__construct(new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__).'/templates')));
        $this->twig->addFilter(new Twig_SimpleFilter('formatDoccomment', function (string $comment, int $indent = 4) : string {
            $lines = explode("\n", $comment);
            $indent = str_repeat(' ', $indent);
            if (count($lines) > 1) {
                array_walk($lines, function (string &$line) use ($indent) {
                    $line = trim($line);
                    $line = trim("$indent * $line");
                });
                array_unshift($lines, "$indent/**");
                $lines[] = "$indent */\n";
            } else {
                $lines = ["$indent/** {$lines[0]} */\n"];
            }
            return implode("\n", $lines);
        }));
    }
}

