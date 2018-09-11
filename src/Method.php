<?php

namespace Codger\Php;

use Twig_Environment;
use DomainException;
use ReflectionFunction;

class Method extends Recipe
{
    protected $template = 'method.html.twig';
    protected $arguments = [];

    public function __construct(string $name, Twig_Environment $twig = null, callable $declaration = null)
    {
        parent::__construct($twig);
        $this->variables->name = $name;
        $this->variables->visibility = 'public';
        if (isset($declaration)) {
            $this->initFromClosure($declaration);
        }
    }

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

    public function setVisibility(string $visibility) : Method
    {
        if (!in_array($visibility, ['public', 'protected', 'private'])) {
            throw new DomainException("Visibility must be one of public, protected or private, not $visibility.");
        }
        $this->variables->visibility = $visibility;
        return $this;
    }

    public function isPrivate() : Method
    {
        return $this->setVisibility('private');
    }

    public function isProtected() : Method
    {
        return $this->setVisibility('protected');
    }

    public function isPublic() : Method
    {
        return $this->setVisibility('public');
    }

    public function isStatic(bool $static = true) : Method
    {
        return $this->set('static', $static);
    }

    public function isFinal(bool $status = true) : Method
    {
        $this->variables->final = $status;
        return $this;
    }

    public function isAbstract(bool $status = true) : Method
    {
        $this->variables->abstract = $status;
        return $this;
    }

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

    public function addArgument(Argument $argument) : Method
    {
        $this->arguments[] = $argument;
        return $this;
    }

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

