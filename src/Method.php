<?php

namespace Codger\Php;

use Twig_Environment;
use DomainException;
use ReflectionFunction;

class Method extends Funktion
{
    use Doccomment;

    public string $visibility;

    public bool $static = false;

    public bool $final = false;

    public bool $abstract = false;

    protected string $_template = 'method.html.twig';

    /**
     * Set the method's visibility.
     *
     * @param string $visibility `public`, `protected` or `private`
     * @return Codger\Php\Method Itself
     */
    public function setVisibility(string $visibility) : self
    {
        if (!in_array($visibility, ['public', 'protected', 'private'])) {
            throw new DomainException("Visibility must be one of public, protected or private, not $visibility.");
        }
        return $this->set('visibility', $visibility);
    }

    /**
     * Mark the method as private.
     *
     * @return Codger\Php\Method Itself
     */
    public function isPrivate() : self
    {
        return $this->setVisibility('private');
    }

    /**
     * Mark the method as protected.
     *
     * @return Codger\Php\Method Itself
     */
    public function isProtected() : self
    {
        return $this->setVisibility('protected');
    }

    /**
     * Mark the method as public.
     *
     * @return Codger\Php\Method Itself
     */
    public function isPublic() : self
    {
        return $this->setVisibility('public');
    }

    /**
     * Mark the method as static (or not).
     *
     * @param bool $static Defaults to `true`
     * @return Codger\Php\Method Itself
     */
    public function isStatic(bool $static = true) : self
    {
        return $this->set('static', $static);
    }

    /**
     * Mark the method as final (or not).
     *
     * @param bool $final Defaults to `true`.
     * @return Codger\Php\Method Itself
     */
    public function isFinal(bool $final = true) : self
    {
        $this->set('final', $final);
        return $this;
    }

    /**
     * Mark the method as abstract (or not).
     *
     * @param bool $abstract Defaults to `true`.
     * @return Codger\Php\Method Itself
     */
    public function isAbstract(bool $abstract = true) : self
    {
        $this->set('abstract', $abstract);
        return $this;
    }

    /**
     * Mark the method as having a body (or not).
     *
     * @param bool $body Defaults to `true`.
     * @return Codger\Php\Method Itself
     */
    public function hasBody(bool $body = true) : self
    {
        $this->set('hasBody', $body);
        return $this;
    }

    /**
     * Set the body of the method. The code is auto-indented.
     *
     * @param string $body
     * @param int $indent Defaults to 8.
     * @return Codger\Php\BaseFunction Itself
     */
    public function setBody(string $body, int $indent = 8) : BaseFunction
    {
        return parent::setBody($body, $indent);
    }
}

