<?php

namespace Codger\Php;

/**
 * Recipe to generate classes.
 */
class Klass extends Interfaze
{
    use CanUseTrait;
    use HasProperties;

    /**
     * Interfaces this class should implement.
     *
     * @var array
     */
    public array $implements = [];

    /** @var string */
    protected string $_template = 'class.html.twig';

    /**
     * Define whether to mark the class as `final`.
     *
     * @param bool $final Defaults to true.
     * @return Codger\Php\Klass
     */
    public function isFinal(bool $final = true) : self
    {
        $this->_variables->final = $final;
        return $this;
    }

    /**
     * Define whether to mark the class as `abstract`.
     *
     * @param bool $abstract Defaults to true.
     * @return Codger\Php\Klass
     */
    public function isAbstract(bool $abstract = true) : self
    {
        $this->_variables->abstract = $abstract;
        return $this;
    }

    /**
     * Define interfaces to implement.
     *
     * @param string ...$interfaces
     * @return Codger\Php\Klass
     */
    public function implementsInterfaces(string ...$interfaces) : self
    {
        $this->_variables->implements = implode(', ', $interfaces);
       return $this;
    }
}

