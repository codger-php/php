<?php

namespace Codger\Php;

use Twig_Environment;
use ReflectionParameter;
use DomainException;

class Konstant extends Recipe
{
    use Doccomment;
    use Quote;

    /** @var string */
    public string $value;

    /** @var string */
    protected string $_template = 'constant.html.twig';

    /**
     * @param array|null $arguments
     * @param Codger\Php\Recipe|null $parent
     */
    public function __construct(array $arguments = null, Recipe $parent = null)
    {
        parent::__construct($arguments, $parent);
        $this->set('visibility', 'public');
        // Obviously constants *ALWAYS* have a value...
        if (!isset($this->value)) {
            $this->setValue(null);
        }
        $this->persistOptionsToTwig('value');
    }

    /**
     * @param mixed $value The value of the constant.
     * @return Codger\Php\Property
     */
    public function setValue($value = null) : Property
    {
        if (isset($value)) {
            return $this->set('value', $this->quote($value));
        } else {
            return $this->set('value', null);
        }
    }

    /**
     * @param string $name
     * @return void
     */
    public function __invoke(string $name) : void
    {
        $this->set('name', $name);
        $this->output("$name.php");
    }
}

