<?php

use Codger\Php\Funktion;
use Codger\Php\Property;

/** Example recipe for generating a PHP method */
return function () : Funktion {
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__).'/../templates'));
    $recipe = new Funktion('testMe', $twig);
    $recipe->setReturnType('string')
        ->setNullable(true)
        ->setBody(<<<EOT
if ((1 + 1) === 2) {
    return 'ok';
} else {
    return null;
}
EOT
        )
        ->output('php://stdout');
    return $recipe;
};

