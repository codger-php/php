<?php

namespace Codger\Php;

trait HasProperties
{
    /**
     * Trait for defining properties on a class or trait. A value of `null`
     * means 'no initial value.
     *
     * @param string $name Name of the property. Omit the dollar sign.
     * @param callable $callback Optional callback. The created property is
     *  passed as argument for further processing.
     * @param string|null $default Optional initial value.
     * @param string $visibility `public`, `protected` or `private`. Defaults to
     *  `public`.
     * @param string|null $doccomment Optional doccomment.
     * @return Codger\Php\Objectesque
     */
    public function defineProperty(string $name, callable $callback = null) : Objectesque
    {
        $property = new Property([$name]);
        if (isset($callback)) {
            $callback($property);
        }
        $property->execute();
        $this->_variables->properties[$name] = $property;
        return $this;
    }
}
