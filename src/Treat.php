<?php

namespace Codger\Php;

/**
 * Recipe to generate traits.
 */
class Treat extends Objectesque
{
    use CanUseTrait;
    use HasProperties;

    /** @var string */
    protected $template = 'trait.html.twig';
}

