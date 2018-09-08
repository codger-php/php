<?php

namespace Codger\Php;

use Twig_Environment;

class Method extends Recipe
{
    protected $template = 'method.html.twig';

    public function __construct(string $name, Twig_Environment $twig = null)
    {
        parent::__construct($twig);
        $this->variables->name = $name;
        $this->variables->visibility = 'public';
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
}

