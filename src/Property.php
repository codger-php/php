<?php

namespace Codger\Php;

use Twig_Environment;
use ReflectionParameter;
use DomainException;

class Property extends Recipe
{
    use Doccomment;
    use Quote;

    /** @var string */
    public $default;

    /** @var string */
    public $visibility;

    /** @var bool */
    public $static = false;

    /** @var string */
    protected $_template = 'property.html.twig';

    /**
     * @param array|null $arguments
     */
    public function __construct(array $arguments = null)
    {
        parent::__construct($arguments);
        $this->set('visibility', 'public');
        $this->persistOptionsToTwig('default');
    }

    /**
     * @param string $visibility
     * @return Codger\Php\Property
     * @throws DomainException if $visibility is not public, protected or
     *  private.
     */
    public function setVisibility(string $visibility) : Property
    {
        if (!in_array($visibility, ['public', 'protected', 'private'])) {
            throw new DomainException("Visibility must be public, protected or private.");
        }
        return $this->set('visibility', $visibility);
    }

    /**
     * @param mixed $default The initial value of the property. Pass null to
     *  remove the initial value completely.
     * @return Codger\Php\Property
     */
    public function setDetault($default = null) : Property
    {
        if (isset($default)) {
            return $this->set('default', $this->quote($default));
        } else {
            return $this->set('default', null);
        }
    }

    /**
     * @param bool $static
     * @return Codger\Php\Property
     */
    public function isStatic(bool $static = true) : Property
    {
        return $this->set('static', $static);
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

