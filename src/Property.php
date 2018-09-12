<?php

namespace Codger\Php;

use Twig_Environment;
use ReflectionParameter;

class Property extends Recipe
{
    use Doccomment;
    use Quote;

    protected $template = 'property.html.twig';

    public function __construct(Twig_Environment $twig, string $name, string $default = null, string $visibility = 'public')
    {
        parent::__construct($twig);
        $this->variables = (object)[
            'default' => $this->quote($default),
            'name' => $name,
            'visibility' => $visibility,
        ];
    }
}

