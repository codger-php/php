<?php

namespace Codger\Php;

trait Doccomment
{
    public function setDoccomment(string $comment) : Recipe
    {
        $lines = explode("\n", $comment);
        if (count($lines) > 1) {
            array_walk($lines, function (string &$line) {
                $line = trim($line);
                $line = "     * $line";
            });
            array_unshift($lines, '    /**');
            $lines[] = "     */\n";
        } else {
            $lines = ["    /** {$lines[0]} */\n"];
        }
        return $this->set('doccomment', implode("\n", $lines));
    }

    public function appendDoccomment(string $comment) : Recipe
    {
        return $this->setDoccomment($this->get('doccomment')."\n\n$comment");
    }
}

