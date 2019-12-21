<?php

namespace Codger\Php;

use Twig_Environment;
use DomainException;
use ReflectionFunction;

class Funktion extends Lambda
{
    use Doccomment;

    /** @var string */
    protected $_template = 'function.html.twig';

    /**
     * @param string $name Name of the function
     * @param Twig_Environment $twig Optional Twig environment
     * @param callable $declaration Optional argument and return type
     *  declaration closure (function can have empty body)
     */
    public function __construct(string $name, Twig_Environment $twig = null, callable $declaration = null)
    {
        parent::__construct($twig, $declaration);
        $this->_variables->name = $name;
    }
}

