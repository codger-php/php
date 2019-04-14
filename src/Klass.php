<?php

namespace Codger\Php;

class Klass extends Interfaze
{
    use CanUseTrait;
    use HasProperties;

    /** @var string */
    protected $template = 'class.html.twig';

    /**
     * Define whether to mark the class as `final`.
     *
     * @param bool $final Defaults to true.
     * @return Codger\Php\Klass
     */
    public function isFinal(bool $final = true) : Klass
    {
        $this->variables->final = $final;
        return $this;
    }

    /**
     * Define whether to mark the class as `abstract`.
     *
     * @param bool $abstract Defaults to true.
     * @return Codger\Php\Klass
     */
    public function isAbstract(bool $abstract = true) : Klass
    {
        $this->variables->abstract = $abstract;
        return $this;
    }
}

