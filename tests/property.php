<?php

use Codger\Php\Property;
use Codger\Generate\{ Recipe, FakeInOut };

Recipe::setInOut(new FakeInOut);

$property = new Property(['user', '--default', 'danny', '--visibility', 'private', '--type', 'string']);
$property->execute();

/** Tests for properties */
return function () use ($property) : Generator {
    /** We can create a property with a default value and a visibility we choose */
    yield function () use ($property) {
        $result = $property->render();
        assert(strpos($result, 'private string $user = \'danny\';'));
    };
};

