<?php

namespace Codger\Php;

/**
 * Recipe to generate traits.
 */
class Treat extends Objectesque
{
    use CanUseTrait;

    /** @var string */
    protected $template = 'trait.html.twig';
}

