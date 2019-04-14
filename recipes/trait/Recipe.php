<?php

use Codger\Php\{ Treat, Method };

/** Example recipe for generating a PHP trait */
return function () : Treat {
    $recipe = new Treat;
    $recipe->setNamespace('Foo\Bar')
        ->usesNamespaces('Bar\Foo')
        ->defineProperty('bla', 'blaat')
        ->defineProperty('blarps', null, 'private')
        ->addMethod('foobar', function (Method $method) : void {
            $method->setBody("return true;");
        })
        ->setName('Test')
        ->usesTraits('Foo\Foobar')
        ->addMethod('foo', function (string $bar = null) : bool {}, function (Method $method) : void {
            $method->isPrivate()
                ->setBody(<<<EOT
return false;
EOT
                );
        })
        ->output('php://stdout');
    return $recipe;
};

