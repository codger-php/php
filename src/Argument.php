<?php

namespace Codger\Php;

use ReflectionParameter;

class Argument extends Recipe
{
    use Doccomment;
    use Quote;

    public bool $variadic = false;

    public bool $optional = false;

    public string $type;

    public string $default;

    public bool $reference = false;

    protected string $_template = 'argument.html.twig';

    /**
     * @param array|null $arguments
     * @param Codger\Php\Recipe|null $parent
     */
    public function __construct(array $arguments = null, Recipe $parent = null)
    {
        parent::__construct($arguments);
        // If the argument is optional (hence might accept null) OR a default
        // value was set (not null), we must quote it for rendering in PHP.
        // Otherwise, we can leave it as is.
        if ($this->optional || isset($this->default)) {
            $this->persistOptionsToTwig('default');
        } else {
            $this->persistOptionsToTwig();
        }
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
    public function isVariadic(bool $variadic = true) : self
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

