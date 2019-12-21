<?php

use Codger\Php\Property;

$property = new Property(['user', '--default', 'danny', '--visibility', 'private']);

/** Tests for properties */
return function () use ($property) : Generator {
    /** We can create a property with a default value and a visibility we choose */
    yield function () use ($property) {
        $result = $property->render();
        assert(strpos($result, 'private $user = \'danny\';'));
    };
};

