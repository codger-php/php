<?php

namespace Codger\Php;

class Klass extends Recipe
{
    use Quote;

    /** @var string */
    protected $template = 'class.html.twig';

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->variables->properties = [];
        $this->variables->methods = [];
    }

    /**
     * Set the namespace of this class.
     *
     * @param string $namespace
     * @return Codger\Php\Klass
     */
    public function setNamespace(string $namespace) : Klass
    {
        $this->variables->namespace = $namespace;
        return $this;
    }

    /**
     * Define which namespaces to `use`.
     *
     * @param string ...$namespaces
     * @return Codger\Php\Klass
     */
    public function usesNamespaces(string ...$namespaces) : Klass
    {
        $this->variables->uses_namespaces = $namespaces;
        return $this;
    }

    /**
     * Set the name of this class.
     *
     * @param string $name
     * @return Codger\Php\Klass
     */
    public function setName(string $name) : Klass
    {
        $this->variables->name = $name;
        return $this;
    }

    /**
     * Define whether to mark the class as `final`.
     *
     * @param bool $final Defaults to true.
     * @return Codger\Php\Klass
     */
    public function isFinal(bool $final = true) : Klass
    {
        $this->variables->final = $final;
        return $this;
    }

    /**
     * Define whether to mark the class as `abstract`.
     *
     * @param bool $abstract Defaults to true.
     * @return Codger\Php\Klass
     */
    public function isAbstract(bool $abstract = true) : Klass
    {
        $this->variables->abstract = $abstract;
        return $this;
    }

    /**
     * Set the parent class. To unset, pass an empty string.
     *
     * @param string $class
     * @return Codger\Php\Klass
     */
    public function extendsClass(string $class) : Klass
    {
        $this->variables->extends = $class;
        return $this;
    }

    /**
     * Define interfaces to implement.
     *
     * @param string ...$interfaces
     * @return Codger\Php\Klass
     */
    public function implementsInterfaces(string ...$interfaces) : Klass
    {
        $this->variables->implements = implode(', ', $interfaces);
        return $this;
    }

    /**
     * Define which traits to `use`.
     *
     * @param string ...$traits
     * @return Codger\Php\Klass
     */
    public function usesTraits(string ...$traits) : Klass
    {
        $this->variables->uses_traits = $traits;
        return $this;
    }

    /**
     * Define class constants. Should be passed as a hash of name/value pairs.
     *
     * @param array $constants
     * @return Codger\Php\Klass
     */
    public function definesConstants(array $constants) : Klass
    {
        foreach ($constants as &$constant) {
            $constant = $this->quote($constant);
        }
        $this->variables->constants = $constants;
        return $this;
    }

    /**
     * Define a class property. A value of `null` means 'no initial value.
     *
     * @param string $name Name of the property. Omit the dollar sign.
     * @param string|null $value Optional initial value.
     * @param string $visibility `public`, `protected` or `private`. Defaults to
     *  `public`.
     * @param string|null $doccomment Optional doccomment.
     * @return Codger\Php\Klass
     */
    public function defineProperty(string $name, string $value = null, string $visibility = 'public', string $doccomment = null) : Klass
    {
        $property = new Property($this->twig, $name, $value, $visibility);
        if ($doccomment) {
            $property->setDoccomment($doccomment);
        }
        $this->variables->properties[] = $property;
        return $this;
    }

    /**
     * Add a method. The callback is called with the new `Codger\Php\Method` as
     * its argument for further processing. Optionally, the second parameter can
     * be a closure defining the method signature, the callback moving to 3rd.
     *
     * If the callback returns a string, it is used to set the method body.
     *
     * @param string $name
     * @param callable ...$callback One or two callbacks, the last receiving the
     *  new method object, the optional first defining the signature.
     * @return Codger\Php\Klass
     */
    public function addMethod(string $name, callable ...$callback) : Klass
    {
        $method = new Method($name, $this->twig, isset($callback[1]) ? $callback[0] : null);
        $body = $callback[isset($callback[1]) ? 1 : 0]($method);
        if (strlen($body)) {
            $method->setBody($body);
        }
        $this->variables->methods[$name] = $method;
        return $this;
    }

    /**
     * Retrieve a method by its name.
     *
     * @param string $name
     * @return Codger\Php\Method|null Either the method requested, else null.
     */
    public function getMethod(string $name) :? Method
    {
        return $this->variables->methods[$name] ?? null;
    }

    /**
     * Render the class.
     *
     * @return string
     */
    public function render() : string
    {
        array_walk($this->variables->methods, function (&$method) {
            $method = $method->render();
        });
        array_walk($this->variables->properties, function (&$property) {
            $property = $property->render();
        });
        return preg_replace("@\n}\n$@m", "}\n", parent::render());
    }
}

