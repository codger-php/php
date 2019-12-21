<?php

namespace Codger\Php;

use Twig_Environment;
use DomainException;
use ReflectionFunction;

class Lambda extends Recipe
{
    use Doccomment;

    /** @var string */
    protected $_template = 'lambda.html.twig';

    /** @var array */
    protected $arguments = [];

    /**
     * @param Twig_Environment $twig Optional Twig environment
     * @param callable $declaration Optional argument and return type
     *  declaration closure (function can have empty body)
     */
    public function __construct(Twig_Environment $twig = null, callable $declaration = null)
    {
        parent::__construct($twig);
        if (isset($declaration)) {
            $this->initFromClosure($declaration);
        }
    }

    /**
     * Initialize this lambda from a closure's signature.
     *
     * @param callable $declaration
     * @return Codger\Php\Lambda Itself
     */
    public function initFromClosure(callable $declaration) : Lambda
    {
        $reflection = new ReflectionFunction($declaration);
        if ($reflection->hasReturnType()) {
            $return = $reflection->getReturnType();
            $this->_variables->returntype = $return;
            $this->_variables->nullable = $return->allowsNull();
        }
        foreach ($reflection->getParameters() as $parameter) {
            $this->addArgument(new Argument($this->twig, $parameter));
        }
        return $this;
    }

    /**
     * Add an argument to the lambda.
     *
     * @param Codger\Php\Argument $argument
     * @return Codger\Php\Lambda Itself
     */
    public function addArgument(Argument $argument) : Lambda
    {
        $this->arguments[$argument->getName()] = $argument;
        return $this;
    }

    /**
     * Set the return type of the lambda.
     *
     * @param string $type
     * @return Codger\Php\Lambda Itself
     */
    public function setReturnType(string $type) : Lambda
    {
        return $this->set('returntype', $type);
    }

    /**
     * Make the lambda nullable (optional return value).
     *
     * @param bool $nullable Defaults to true.
     * @return Codger\Php\Lambda Itself
     */
    public function setNullable(bool $nullable = true) : Lambda
    {
        return $this->set('nullable', $nullable);
    }

    /**
     * Set the body of the lambda. The code is auto-indented.
     *
     * @param string $body
     * @param int $indent Number of spaces to indent with. Defaults to 4.
     * @return Codger\Php\Lambda Itself
     */
    public function setBody(string $body, int $indent = 4) : Lambda
    {
        $body = trim($body);
        $lines = explode("\n", $body);
        foreach ($lines as &$line) {
            $line = str_repeat(' ', $indent).$line;
        }
        $this->_variables->body = implode("\n", $lines);
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
        foreach ($this->arguments as $argument) {
            $arguments[] = $argument->render();
        }
        $this->_variables->arguments = implode(', ', $arguments);
        return parent::render();
    }
}

