<?php

namespace Codger\Php;

use Twig_SimpleFilter;

/**
 * `use` this trait for any recipe that needs to support doccomments.
 */
trait Doccomment
{
    /**
     * @var string $comment
     * @return Codger\Php\Recipe
     */
    public function setDoccomment(string $comment) : Recipe
    {
        static $inited = false;
        if (!$inited) {
            $this->twig->addFiler(new Twig_SimpleFilter('formatDoccomment', function (string $comment, bool $indent = true) : string {
                $lines = explode("\n", $comment);
                $indent = $indent ? '    ' : '';
                if (count($lines) > 1) {
                    array_walk($lines, function (string &$line) {
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
            $inited = true;
        }
        return $this->set('doccoment', $comment);
    }

    /**
     * Append a doccomment to an already existing one. This is useful if you
     * need to add to auto-generated comments.
     *
     * @param string $comment
     * @return Codger\Php\Recipe
     */
    public function appendDoccomment(string $comment) : Recipe
    {
        return $this->setDoccomment($this->get('doccomment').$comment);
    }
}

