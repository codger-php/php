<?php

namespace Codger\Php;

use Codger\Generate\Recipe;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Klass extends Recipe
{
    public function __construct()
    {
        parent::__construct(new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__).'/templates')));
    }
}

