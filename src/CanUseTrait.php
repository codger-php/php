<?php

namespace Codger\Php;

trait CanUseTrait
{
    /**
     * Define which traits to `use`.
     *
     * @param string ...$traits
     * @return Codger\Php\Objectesque
     */
    public function usesTraits(string ...$traits) : Objectesque
    {
        return $this->set('uses_traits', $traits);
    }
}
