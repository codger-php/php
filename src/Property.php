<?php

namespace Codger\Php;

use Twig_Environment;
use ReflectionParameter;

class Property extends Recipe
{
    use Doccomment;
    use Quote;

    /** @var string */
    protected $template = 'property.html.twig';

    /**
     * @param Twig_Environment $twig
     * @param string $name
     * @param string $default Optional default
     * @param string $visibility Optional visibility, defaults to `public`
     */
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

