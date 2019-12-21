<?php

namespace Codger\Php;

trait HasProperties
{
    /**
     * Trait for defining properties on a class or trait. A value of `null`
     * means 'no initial value.
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
        $arguments = [$name, "--visibility", $visibility];
        if (!is_null($value)) {
            $arguments[] = "--value=";
            $arguments[] = $value;
        }
        $property = new Property($arguments);
        if ($doccomment) {
            $property->setDoccomment($doccomment);
        }
        $property->execute();
        $this->_variables->properties[$name] = $property;
        return $this;
    }
}
