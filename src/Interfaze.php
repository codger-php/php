<?php

namespace Codger\Php;

/**
 * Class to generate interfaces.
 */
class Interfaze extends Objectesque
{
    /** @var string */
    public $extends = '';

    /** @var string */
    protected $_template = 'interface.html.twig';

    /**
     * Set the parent class. To unset, pass an empty string.
     *
     * @param string $class
     * @return Codger\Php\Objectesque
     */
    public function extendsClass(string $class) : Objectesque
    {
        $this->_variables->extends = $class;
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
        $this->_variables->constants += $constants;
        return $this;
    }
}

