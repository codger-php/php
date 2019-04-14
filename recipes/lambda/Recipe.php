<?php

use Codger\Php\Lambda;
use Codger\Php\Property;

/** Example recipe for generating a PHP  */
return function () : Lambda {
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__).'/../templates'));
    $recipe = new Lambda($twig);
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

