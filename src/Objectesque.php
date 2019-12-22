<?php

namespace Codger\Php;

abstract class Objectesque extends Recipe
{
    use Quote;
    use Doccomment;

    /** @var array */
    public $namespace = [];
    /** @var array */
    public $usesNamespace = [];

    /** @var string */
    protected $_template;

    /**
     * Constructor.
     *
     * @param array|null $arguments
     * @return void
     */
    public function __construct(array $arguments = null)
    {
        parent::__construct($arguments);
        $this->_variables->properties = [];
        $this->_variables->methods = [];
        $this->_variables->constants = [];
        $this->persistOptionsToTwig();
    }

    /**
     * Set the namespace of this entity.
     *
     * @param string $namespace
     * @return Codger\Php\Objectesque
     */
    public function setNamespace(string $namespace) : Objectesque
    {
        if (strtolower($namespace) == 'global') {
            $namespace = null;
        }
        $this->_variables->namespace = $namespace;
        return $this;
    }

    /**
     * Define which namespaces to `use`.
     *
     * @param string ...$namespaces
     * @return Codger\Php\Objectesque
     */
    public function usesNamespaces(string ...$namespaces) : Objectesque
    {
        $this->_variables->usesNamespace = $namespaces;
        return $this;
    }

    /**
     * Set the name of this entity.
     *
     * @param string $name
     * @return Codger\Php\Objectesque
     */
    public function setName(string $name) : Objectesque
    {
        $this->_variables->name = $name;
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
     * @return Codger\Php\Objectesque
     */
    public function addMethod(string $name, callable ...$callback) : Objectesque
    {
        $method = new Method([$name, '--visibility=public'], isset($callback[1]) ? $callback[0] : null);
        if (!isset($callback[0])) {
            $callback[0] = function () : string { return ''; };
        }
        $body = $callback[isset($callback[1]) ? 1 : 0]($method);
        if (strlen($body)) {
            $method->setBody($body);
        }
        // In a pure interface we don't show the body, ever.
        if (!($this instanceof Klass || $this instanceof Treat)) {
            $method->hasBody(false);
        }
        $method->execute();
        $this->_variables->methods[$name] = $method;
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
        return $this->_variables->methods[$name] ?? null;
    }

    /**
     * Render the class.
     *
     * @return string
     */
    public function render() : string
    {
        uasort($this->_variables->methods, [$this, 'sortByVisibility']);
        uasort($this->_variables->properties, [$this, 'sortByVisibility']);
        array_walk($this->_variables->constants, function (&$constant) {
            if (!is_string($constant)) {
                $constant = $constant->render();
            }
        });
        array_walk($this->_variables->methods, function (&$method) {
            if (!is_string($method)) {
                $method = $method->render();
            }
        });
        array_walk($this->_variables->properties, function (&$property) {
            if (!is_string($property)) {
                $property = $property->render();
            }
        });
        return parent::render();
    }

    /**
     * @param string $name
     * @return void
     */
    public function __invoke(string $name) : void
    {
        $this->output("$name.php");
    }

    /**
     * Sort elements by visibility: public, protected, then private, with static
     * before non-static.
     *
     * @param object $a
     * @param object $b
     * @return int -1, 0 or 1
     */
    private function sortByVisibility(object $a, object $b) : int
    {
        $va = $a->get('visibility');
        $vb = $b->get('visibility');
        if ($va == 'public' && $vb != 'public') {
            return -1;
        }
        if ($va == 'protected' && $vb == 'private') {
            return -1;
        }
        if ($vb == 'public' && $va != 'public') {
            return 1;
        }
        if ($vb == 'protected' && $va == 'private') {
            return 1;
        }
        $sa = $a->get('static');
        $sb = $b->get('static');
        if ($sa && !$sb) {
            return -1;
        }
        if ($sb && !$sa) {
            return 1;
        }
        return 0;
    }
}

