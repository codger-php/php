<?php

namespace Codger\Php;

class Klass extends Recipe
{
    protected $template = 'class.html.twig';

    public function __construct()
    {
        parent::__construct();
        $this->variables->variables = [];
        $this->variables->methods = [];
    }

    public function setNamespace(string $namespace) : Klass
    {
        $this->variables->namespace = $namespace;
        return $this;
    }

    public function usesNamespaces(string ...$namespaces) : Klass
    {
        $this->variables->uses_namespaces = $namespaces;
        return $this;
    }

    public function setName(string $name) : Klass
    {
        $this->variables->name = $name;
        return $this;
    }

    public function isFinal(bool $final = true) : Klass
    {
        $this->variables->final = $final;
        return $this;
    }

    public function isAbstract(bool $abstract = true) : Klass
    {
        $this->variables->abstract = $abstract;
        return $this;
    }

    public function extendsClass(string $class) : Klass
    {
        $this->variables->extends = $class;
        return $this;
    }

    public function implementsInterfaces(string ...$interfaces) : Klass
    {
        $this->variables->implements = implode(', ', $interfaces);
        return $this;
    }

    public function usesTraits(string ...$traits) : Klass
    {
        $this->variables->uses_traits = $traits;
        return $this;
    }

    public function definesConstants(array $constants) : Klass
    {
        foreach ($constants as &$constant) {
            $constant = $this->quote($constant);
        }
        $this->variables->constants = $constants;
        return $this;
    }

    public function defineVariable(string $name, string $value = null, string $visibility = 'public') : Klass
    {
        $value = $this->quote($value);
        $this->variables->variables[] = compact('name', 'visibility', 'value');
        return $this;
    }

    public function addMethod($name, callable $callback) : Klass
    {
        $method = new Method($name, $this->twig);
        $callback($method);
        $this->variables->methods[$name] = $method->render();
        return $this;
    }

    public function getMethod(string $name) :? Method
    {
        return $this->variables->methods[$name] ?? null;
    }

    public function render() : string
    {
        return preg_replace("@\n}\n$@m", "}\n", parent::render());
    }

    protected function quote(string $unquoted = null) : string
    {
        if (is_null($unquoted)) {
            return 'NULL';
        }
        if (is_numeric($unquoted)) {
            return (string)$unquoted;
        }
        return "'".str_replace("'", "\'", $unquoted)."'";
    }
}

