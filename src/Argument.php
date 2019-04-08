<?php

namespace Codger\Php;

use Twig_Environment;
use ReflectionParameter;

class Argument extends Recipe
{
    use Doccomment;

    /** @var string */
    protected $template = 'argument.html.twig';

    /**
     * @param Twig_Environment $twig
     * @param ReflectionParameter $parameter Optional reflection parameter for
     *  quick definition.
     */
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
            $this->variables->reference = $parameter->isPassedByReference();
        }
    }

    /**
     * Mark the argument as variadic (or not).
     *
     * @param bool $variadic Defaults to `true`
     * @return Codger\Php\Argument Itself
     */
    public function isVariadic(bool $variadic = true) : Argument
    {
        return $this->set('variadic', $variadic);
    }

    /**
     * Get the name of the parameter (if set, else null).
     *
     * @return string|null
     */
    public function getName() :? string
    {
        return $this->get('name');
    }
}

