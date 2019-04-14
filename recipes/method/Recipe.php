<?php

use Codger\Php\Method;
use Codger\Php\Property;

/** Example recipe for generating a PHP method */
return function () : Method {
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__).'/../templates'));
    $recipe = new Method('testMe', $twig);
    $recipe->isPrivate()
        ->isStatic()
        ->isFinal()
        ->setReturnType('string')
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

