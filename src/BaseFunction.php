<?php

namespace Codger\Php;

use ReflectionFunction;

abstract class BaseFunction extends Recipe
{
    use Doccomment;

    /** @var string */
    protected $_template;

    /** @var array */
    protected $_arguments = [];

    /**
     * @param array|null $arguments
     * @param callable $declaration Optional argument and return type
     *  declaration closure (function can have empty body)
     */
    public function __construct(array $arguments = null, callable $declaration = null)
    {
        parent::__construct($arguments);
        if ($this instanceof Method) {
            $this->set('visibility', 'public');
        }
        $this->persistOptionsToTwig();
        if (isset($declaration)) {
            $this->initFromClosure($declaration);
        }
    }

    /**
     * Initialize this lambda from a closure's signature.
     *
     * @param callable $declaration
     * @return Codger\Php\BaseFunction Itself
     */
    public function initFromClosure(callable $declaration) : BaseFunction
    {
        $reflection = new ReflectionFunction($declaration);
        if ($reflection->hasReturnType()) {
            $return = $reflection->getReturnType();
            $this->set('returntype', $return);
            $this->set('nullable', $return->allowsNull());
        } else {
            $this->set('returntype', null);
            $this->set('nullable', null);
        }
        $this->_arguments = [];
        foreach ($reflection->getParameters() as $parameter) {
            $arguments = [$parameter->name];
            if ($parameter->isOptional()) {
                $arguments[] = '--optional';
            }
            if ($type = $parameter->getType()) {
                $arguments[] = '--type';
                $arguments[] = "$type";
            }
            if ($parameter->isPassedByReference()) {
                $arguments[] = '--reference';
            }
            if ($parameter->isVariadic()) {
                $arguments[] = '--variadic';
            }
            $argument = new Argument($arguments);
            $argument->execute();
            $this->addArgument($argument);
        }
        return $this;
    }

    /**
     * Add an argument to the lambda.
     *
     * @param Codger\Php\Argument $argument
     * @return Codger\Php\BaseFunction Itself
     */
    public function addArgument(Argument $argument) : BaseFunction
    {
        $this->_arguments[$argument->getName()] = $argument;
        return $this;
    }

    /**
     * Set the return type of the lambda.
     *
     * @param string $type
     * @return Codger\Php\BaseFunction Itself
     */
    public function setReturnType(string $type) : BaseFunction
    {
        return $this->set('returntype', $type);
    }

    /**
     * Make the lambda nullable (optional return value).
     *
     * @param bool $nullable Defaults to true.
     * @return Codger\Php\BaseFunction Itself
     */
    public function setNullable(bool $nullable = true) : BaseFunction
    {
        return $this->set('nullable', $nullable);
    }

    /**
     * Set the body of the lambda. The code is auto-indented.
     *
     * @param string $body
     * @param int $indent Number of spaces to indent with. Defaults to 4.
     * @return Codger\Php\BaseFunction Itself
     */
    public function setBody(string $body, int $indent = 4) : BaseFunction
    {
        $body = trim($body);
        $lines = explode("\n", $body);
        foreach ($lines as &$line) {
            $line = str_repeat(' ', $indent).$line;
        }
        $this->set('body', implode("\n", $lines));
        $this->set('hasBody', true);
        return $this;
    }

    /**
     * Render the lambda.
     *
     * @return string
     */
    public function render() : string
    {
        $arguments = [];
        foreach ($this->_arguments as $argument) {
            $arguments[] = $argument->render();
        }
        $this->_variables->arguments = implode(', ', $arguments);
        return parent::render();
    }
}

