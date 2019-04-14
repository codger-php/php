<?php

namespace Codger\Php;

trait HasProperties
{
    /**
     * Define a class por trait roperty. A value of `null` means 'no initial
     * value.
     *
     * @param string $name Name of the property. Omit the dollar sign.
     * @param string|null $value Optional initial value.
     * @param string $visibility `public`, `protected` or `private`. Defaults to
     *  `public`.
     * @param string|null $doccomment Optional doccomment.
     * @return Codger\Php\Objectesque
     */
    public function defineProperty(string $name, string $value = null, string $visibility = 'public', string $doccomment = null) : Objectesque
    {
        $property = new Property($this->twig, $name, $value, $visibility);
        if ($doccomment) {
            $property->setDoccomment($doccomment);
        }
        $this->variables->properties[$name] = $property;
        return $this;
    }
}
