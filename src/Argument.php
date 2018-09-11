<?php

namespace Codger\Php;

use Twig_Environment;
use ReflectionParameter;

class Argument extends Recipe
{
    protected $template = 'argument.html.twig';

    public function __construct(Twig_Environment $twig, ReflectionParameter $parameter = null)
    {
        $this->variables = (object)[
            'variadic' => false,
            'default' => false,
            'name' => false,
            'optional' => false,
        ];
        if (isset($parameter)) {
            $this->isVariadic($parameter->isVariadic());
        }
    }

    public function isVariadic(bool $variadic = true) : Argument
    {
        return $this->set('variadic', $variadic);
    }
}

