<?php

use Codger\Php\{ Interfaze, Method };

/** Example recipe for generating a PHP interface */
return function () : Interfaze {
    $recipe = new Interfaze;
    $recipe->setNamespace('Foo\Bar')
        ->usesNamespaces('Bar\Foo')
        ->extendsClass('Something')
        ->addMethod('foobar', function (Method $method) : void {
            $method->setBody("return true;");
        })
        ->setName('Test')
        ->addMethod('foo', function (string $bar = null) : bool {}, function (Method $method) : void {
            $method->isPrivate()
                ->setBody(<<<EOT
return false;
EOT
                );
        })
        ->definesConstants([
            'FOO' => 'bar',
            'BAR' => 2,
        ])
        ->output('php://stdout');
    return $recipe;
};

