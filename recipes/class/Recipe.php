<?php

return function () : Codger\Php\Klass {
    $recipe = new Codger\Php\Klass;
    $recipe->setNamespace('Foo\Bar')
        ->usesNamespaces('Bar\Foo')
        ->extendsClass('Something')
        ->implementsInterfaces('Bla', 'Barf')
        ->defineVariable('bla', 'blaat')
        ->defineVariable('blarps', null, 'private')
        ->addMethod('foobar', function (Codger\Php\Method $method) : void {
            $method->setBody("return true;");
        })
        ->setName('Test')
        ->isFinal()
        ->isAbstract()
        ->usesTraits('Foo\Foobar')
        ->addMethod('foo', function ($method) {
            $method->initFromClosure(function (string $bar = null) : bool {})
                ->setBody(<<<EOT
            return false;
EOT
                )
                ->isPrivate();
        })
        ->definesConstants([
            'FOO' => 'bar',
            'BAR' => 2,
        ])
        ->output('php://stdout');
    return $recipe;
};

