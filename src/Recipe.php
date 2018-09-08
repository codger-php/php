<?php

namespace Codger\Php;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Codger\Generate;

abstract class Recipe extends Generate\Recipe
{
    public function __construct()
    {
        parent::__construct(new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__).'/templates')));
    }
}

