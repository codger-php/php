<?php

namespace Codger\Php;

class Composer
{
    private $composer;

    public function __construct(string $path = null)
    {
        $path = $path ?? getcwd();
        $this->composer = json_decode(file_get_contents("$path/composer.json"));
    }

    public function hasDependency(string $name) : bool
    {
        return array_key_exists($name, $this->composer->require);
    }

    public function addDependency(string $name) : void
    {
        exec("composer require $name");
    }
}

