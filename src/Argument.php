<?php

namespace Codger\Php;

use ReflectionParameter;

class Argument extends Recipe
{
    use Doccomment;

    /** @var bool */
    public $variadic = false;

    /** @var string */
    public $name = '';

    /** @var bool */
    public $optional = false;

    /** @var string */
    public $type = '';

    /** @var bool */
    public $reference = false;

    /** @var string */
    protected $_template = 'argument.html.twig';

    /**
     * @param array|null $arguments
     * @param ReflectionParameter $parameter Optional reflection parameter for
     *  quick definition.
     */
    public function __construct(array $arguments = null, ReflectionParameter $parameter = null)
    {
        parent::__construct($arguments);
        $this->persistOptionsToTwig();
        if (isset($parameter)) {
            $this->isVariadic($parameter->isVariadic())
                ->set('name', $parameter->name)
                ->set('optional', $parameter->isOptional())
                ->set('type', $parameter->getType())
                ->set('reference', $parameter->isPassedByReference());
        }
    }

    public function __invoke() : void
    {
        $this->output($this->get('name').'.php');
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

