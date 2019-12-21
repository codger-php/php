<?php

namespace Codger\Php;

use Twig_Environment;
use ReflectionParameter;

class Property extends Recipe
{
    use Doccomment;
    use Quote;

    /** @var string */
    public $default;

    /** @var string */
    public $visibility;

    /** @var string */
    protected $_template = 'property.html.twig';

    /**
     * @param array|null $arguments
     */
    public function __construct(array $arguments = null)
    {
        parent::__construct($arguments);
        $this->set('visibility', 'public');
        if (isset($this->default)) {
            $this->persistOptionsToTwig('default');
        } else {
            $this->persistOptionsToTwig();
        }
    }

    public function __invoke(string $name)
    {
        $this->set('name', $name);
        $this->output("$name.php");
    }
}

