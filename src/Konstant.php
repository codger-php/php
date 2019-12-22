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
    public $value;

    /** @var string */
    protected $_template = 'constant.html.twig';

    /**
     * @param array|null $arguments
     */
    public function __construct(array $arguments = null)
    {
        parent::__construct($arguments);
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

