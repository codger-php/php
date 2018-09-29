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
        return (isset($this->composer->require) && array_key_exists($name, $this->composer->require))
            || (isset($this->composer->{'require-dev'}) && array_key_exists($name, $this->composer->{'require-dev'}));
    }

    public function addDependency(string $name, bool $dev = false) : void
    {
        if (!$this->hasDependency($name)) {
            $dev = $dev ? '--dev ' : '';
            exec("composer require $dev$name");
        }
    }
}

