<?php

use Gentry\Gentry\Wrapper;
use Codger\Php\Property;

$twig = new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__).'/templates'));

$property = Wrapper::createObject(Property::class, $twig, 'user', 'danny', 'private');

/** We can create a property with a default value and a visibility we choose */
return function () use ($property) : Generator {
    yield function () use ($property) {
        $result = $property->render();
        assert(strpos($result, 'private $user = \'danny\';'));
    };
};

