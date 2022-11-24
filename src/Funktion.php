<?php

namespace Codger\Php;

class Funktion extends BaseFunction
{
    protected string $_template = 'function.html.twig';

    public function __invoke(string $name) : void
    {
        $this->set('name', $name);
        $this->output("$name.php");
    }
}

