<?php

namespace Codger\Php;

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
        return $this->set('doccomment', $comment);
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

