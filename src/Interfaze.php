<?php

namespace Codger\Php;

/**
 * Class to generate interfaces.
 */
class Interfaze extends Objectesque
{
    /** @var string */
    public $extends;

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
     * Define class constant. The optional $callback is called with the new
     * constant as it argument.
     *
     * @param string $name
     * @param mixed $value
     * @param callable $callback
     * @return Codger\Php\Objectesque
     */
    public function definesConstant(string $name, $value, callable $callback = null) : Objectesque
    {
        $constant = new Konstant([$name, '--value', $value]);
        $constant->execute();
        if (isset($callback)) {
            $callback($constant);
        }
        $this->_variables->constants[$name] = $constant;
        return $this;
    }
}

