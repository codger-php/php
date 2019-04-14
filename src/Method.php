<?php

namespace Codger\Php;

use Twig_Environment;
use DomainException;
use ReflectionFunction;

class Method extends Recipe
{
    use Doccomment;

    /** @var string */
    protected $template = 'method.html.twig';

    /** @var array */
    protected $arguments = [];

    /**
     * @param string $name Name of the method
     * @param Twig_Environment $twig Optional Twig environment
     * @param callable $declaration Optional argument and return type
     *  declaration closure (function can have empty body)
     */
    public function __construct(string $name, Twig_Environment $twig = null, callable $declaration = null)
    {
        parent::__construct($twig);
        $this->variables->name = $name;
        $this->variables->hasBody = true;
        $this->variables->visibility = 'public';
        if (isset($declaration)) {
            $this->initFromClosure($declaration);
        }
    }

    /**
     * Initialize this method from a closure's signature.
     *
     * @param callable $declaration
     * @return Codger\Php\Method Itself
     */
    public function initFromClosure(callable $declaration) : Method
    {
        $reflection = new ReflectionFunction($declaration);
        if ($reflection->hasReturnType()) {
            $return = $reflection->getReturnType();
            $this->variables->returntype = $return;
            $this->variables->nullable = $return->allowsNull();
        }
        foreach ($reflection->getParameters() as $parameter) {
            $this->addArgument(new Argument($this->twig, $parameter));
        }
        return $this;
    }

    /**
     * Set the method's visibility.
     *
     * @param string $visibility `public`, `protected` or `private`
     * @return Codger\Php\Method Itself
     */
    public function setVisibility(string $visibility) : Method
    {
        if (!in_array($visibility, ['public', 'protected', 'private'])) {
            throw new DomainException("Visibility must be one of public, protected or private, not $visibility.");
        }
        $this->variables->visibility = $visibility;
        return $this;
    }

    /**
     * Mark the method as private.
     *
     * @return Codger\Php\Method Itself
     */
    public function isPrivate() : Method
    {
        return $this->setVisibility('private');
    }

    /**
     * Mark the method as protected.
     *
     * @return Codger\Php\Method Itself
     */
    public function isProtected() : Method
    {
        return $this->setVisibility('protected');
    }

    /**
     * Mark the method as public.
     *
     * @return Codger\Php\Method Itself
     */
    public function isPublic() : Method
    {
        return $this->setVisibility('public');
    }

    /**
     * Mark the method as static (or not).
     *
     * @param bool $static Defaults to `true`
     * @return Codger\Php\Method Itself
     */
    public function isStatic(bool $static = true) : Method
    {
        return $this->set('static', $static);
    }

    /**
     * Mark the method as final (or not).
     *
     * @param bool $final Defaults to `true`.
     * @return Codger\Php\Method Itself
     */
    public function isFinal(bool $final = true) : Method
    {
        $this->variables->final = $final;
        return $this;
    }

    /**
     * Mark the method as abstract (or not).
     *
     * @param bool $abstract Defaults to `true`.
     * @return Codger\Php\Method Itself
     */
    public function isAbstract(bool $abstract = true) : Method
    {
        $this->variables->abstract = $abstract;
        $this->variables->hasBody = !$abstract;
        return $this;
    }

    /**
     * Mark the method as having a body (or not).
     */
    public function hasBody(bool $body = true) : Method
    {
        $this->variables->hasBody = $body;
    }

    /**
     * Add an argument to the method.
     *
     * @param Codger\Php\Argument $argument
     * @return Codger\Php\Method Itself
     */
    public function addArgument(Argument $argument) : Method
    {
        $this->arguments[$argument->getName()] = $argument;
        return $this;
    }

    /**
     * Set the return type of the method.
     *
     * @param string $type
     * @return Codger\Php\Method Itself
     */
    public function setReturnType(string $type) : Method
    {
        return $this->set('returntype', $type);
    }

    /**
     * Make the method nullable (optional return value).
     *
     * @param bool $nullable Defaults to true.
     * @return Codger\Php\Method Itself
     */
    public function setNullable(bool $nullable = true) : Method
    {
        return $this->set('nullable', $nullable);
    }

    /**
     * Set the body of the method. The code is auto-indented with 8 spaces.
     *
     * @param string $body
     * @return Codger\Php\Method Itself
     */
    public function setBody(string $body) : Method
    {
        $body = trim($body);
        $lines = explode("\n", $body);
        foreach ($lines as &$line) {
            $line = "        $line";
        }
        $this->variables->body = implode("\n", $lines);
        return $this;
    }

    /**
     * Render the method.
     *
     * @return string
     */
    public function render() : string
    {
        $arguments = [];
        foreach ($this->arguments as $argument) {
            $arguments[] = $argument->render();
        }
        $this->variables->arguments = implode(', ', $arguments);
        return parent::render();
    }
}

