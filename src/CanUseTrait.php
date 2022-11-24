<?php

namespace Codger\Php;

trait CanUseTrait
{
    /**
     * Traits this object should `use`.
     *
     * @var array
     */
    public array $usesTrait = [];

    /**
     * Define which traits to `use`.
     *
     * @param string ...$traits
     * @return Codger\Php\Objectesque
     */
    public function usesTraits(string ...$traits) : Objectesque
    {
        return $this->set('usesTrait', $traits);
    }
}
