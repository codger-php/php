<?php

namespace Codger\Php;

use ReflectionParameter;

class Argument extends Recipe
{
    use Doccomment;
    use Quote;

    /** @var bool */
    public $variadic = false;

    /** @var bool */
    public $optional = false;

    /** @var string */
    public $type;

    /** @var string */
    public $default;

    /** @var bool */
    public $reference = false;

    /** @var string */
    protected $_template = 'argument.html.twig';

    /**
     * @param array|null $arguments
     *  quick definition.
     */
    public function __construct(array $arguments = null)
    {
        parent::__construct($arguments);
        $this->persistOptionsToTwig('default');
    }

    public function __invoke(string $name) : void
    {
        $this->set('name', $name);
        $this->output("$name.php");
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

