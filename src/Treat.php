<?php

namespace Codger\Php;

/**
 * Recipe to generate traits.
 */
class Treat extends Objectesque
{
    use CanUseTrait;
    use HasProperties;

    protected string $_template = 'trait.html.twig';
}

