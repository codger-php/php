<?php

namespace Codger\Php;

trait Doccomment
{
    public function addDoccomment(string $comment) : Recipe
    {
        $lines = explode("\n", $comment);
        if (count($lines) > 1) {
            array_walk($lines, function (string &$line) {
                $line = trim($line);
                $line = " * $line";
            });
        } else {
            $lines = ["/** {$lines[0]} */"];
        }
        return $this->set('doccomment', implode("\n", $lines));
    }
}

