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
     * @param array|null $arguments
     * @param callable $declaration Optional argument and return type
     *  declaration closure (function can have empty body)
     */
    public function __construct(array $arguments = null, callable $declaration = null)
    {
        parent::__construct($arguments, $declaration);
    }

    public function __invoke(string $name) : void
    {
        $this->set('name', $name);
        parent::__invoke();
    }
}

