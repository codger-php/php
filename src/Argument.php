<?php

namespace Codger\Php;

use Twig_Environment;
use ReflectionParameter;

class Argument extends Recipe
{
    use Doccomment;

    protected $template = 'argument.html.twig';

    public function __construct(Twig_Environment $twig, ReflectionParameter $parameter = null)
    {
        parent::__construct($twig);
        $this->variables = (object)[
            'type' => false,
            'variadic' => false,
            'default' => false,
            'name' => false,
            'optional' => false,
        ];
        if (isset($parameter)) {
            $this->isVariadic($parameter->isVariadic());
            $this->variables->name = $parameter->name;
            $this->variables->optional = $parameter->isOptional();
            $this->variables->type = $parameter->getType();
        }
    }

    public function isVariadic(bool $variadic = true) : Argument
    {
        return $this->set('variadic', $variadic);
    }
}

