<?php

namespace Codger\Php;

use Twig_Environment;
use DomainException;
use ReflectionFunction;

class Method extends Funktion
{
    use Doccomment;

    /** @var string */
    protected $template = 'method.html.twig';

    /**
     * @param string $name Name of the method
     * @param Twig_Environment $twig Optional Twig environment
     * @param callable $declaration Optional argument and return type
     *  declaration closure (function can have empty body)
     */
    public function __construct(string $name, Twig_Environment $twig = null, callable $declaration = null)
    {
        parent::__construct($name, $twig, $declaration);
        $this->variables->hasBody = true;
        $this->variables->visibility = 'public';
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
     *
     * @param bool $body Defaults to `true`.
     * @return Codger\Php\Method Itself
     */
    public function hasBody(bool $body = true) : Method
    {
        $this->variables->hasBody = $body;
        return $this;
    }

    /**
     * Set the body of the method. The code is auto-indented.
     *
     * @param string $body
     * @param int $indent Defaults to 8.
     * @return Codger\Php\Lambda Itself
     */
    public function setBody(string $body, int $indent = 8) : Lambda
    {
        return parent::setBody($body, $indent);
    }
}

