<?php

namespace Codger\Php;

use Twig\{ Environment, Loader\FilesystemLoader, TwigFilter };
use Codger\Generate;

/**
 * Abstract base recipe all PHP recipes should extend.
 */
abstract class Recipe extends Generate\Recipe
{
    /**
     * Constructor.
     *
     * @param array|null $arguments
     * @return void
     */
    public function __construct(array $arguments = null)
    {
        parent::__construct($arguments);
        $twig = new Environment(new FilesystemLoader(dirname(__DIR__).'/templates'));
        $twig->addFilter(new TwigFilter('formatDoccomment', function (string $comment, int $indent = 4) : string {
            $lines = explode("\n", $comment);
            $indent = str_repeat(' ', $indent);
            if (count($lines) > 1) {
                array_walk($lines, function (string &$line) use ($indent) {
                    $line = trim($line);
                    $line = "$indent * $line";
                });
                array_unshift($lines, "$indent/**");
                $lines[] = "$indent */\n";
            } else {
                $lines = ["$indent/** {$lines[0]} */\n"];
            }
            return implode("\n", $lines);
        }));
        $this->setTwigEnvironment($twig);
    }

    public function render() : string
    {
        $result = parent::render();
        return preg_replace(["@\n\n(\s*)}@m", "@(\s*){\n\n@m"], ["\n\\1}", "\\1{\n"], $result);
    }
}

