<?php

namespace Codger\Php;

class Interfaze extends Objectesque
{
    /**
     * Set the parent class. To unset, pass an empty string.
     *
     * @param string $class
     * @return Codger\Php\Objectesque
     */
    public function extendsClass(string $class) : Objectesque
    {
        $this->variables->extends = $class;
        return $this;
    }

    /**
     * Define interfaces to implement.
     *
     * @param string ...$interfaces
     * @return Codger\Php\Objectesque
     */
    public function implementsInterfaces(string ...$interfaces) : Objectesque
    {
        $this->variables->implements = implode(', ', $interfaces);
        return $this;
    }

    /**
     * Define class constants. Should be passed as a hash of name/value pairs.
     *
     * @param array $constants
     * @return Codger\Php\Objectesque
     */
    public function definesConstants(array $constants) : Objectesque
    {
        foreach ($constants as &$constant) {
            $constant = $this->quote($constant);
        }
        $this->variables->constants += $constants;
        return $this;
    }
}

