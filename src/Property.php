<?php

namespace Codger\Php;

use Twig_Environment;
use ReflectionParameter;
use DomainException;

class Property extends Recipe
{
    use Doccomment;
    use Quote;

    public string $default;

    public string $visibility;

    public bool $static = false;

    public string $type;

    protected string $_template = 'property.html.twig';

    /**
     * @param array|null $arguments
     * @param Codger\Php\Recipe|null $parent
     */
    public function __construct(array $arguments = null, Recipe $parent = null)
    {
        parent::__construct($arguments, $parent);
        if (!isset($this->visibility)) {
            $this->set('visibility', 'public');
        }
        $this->persistOptionsToTwig();
        if (isset($this->default)) {
            $this->setDefault($this->default);
        }
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
     * @param string $type
     * @return Codger\Php\Property
     */
    public function setType(string $type) : Property
    {
        return $this->set('type', $type);
    }

    /**
     * @param mixed $default The initial value of the property.
     * @return Codger\Php\Property
     */
    public function setDefault(mixed $default = null) : Property
    {
        $this->set('hasDefault', true);
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

