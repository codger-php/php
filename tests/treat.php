<?php

use Codger\Php\Treat;

$trait = new Treat(['Test']);
$trait->execute();

/** Test Treat */
return function () use ($trait) : Generator {
    /** setNamespace sets a namespace for our trait */
    yield function () use ($trait) {
        $trait->setNamespace('Unittest');
        $result = $trait->render();
        assert(strpos($result, 'namespace Unittest'));
    };
    
    /** usesNamespaces lets us use a namespace */
    yield function () use ($trait) {
        $trait->usesNamespaces('Tools');
        $result = $trait->render();
        assert(strpos($result, 'use Tools'));
    };
    
    /** setName lets us name our trait */
    yield function () use ($trait) {
        $trait->setName('Technology');
        $result = $trait->render();
        assert(strpos($result, 'trait Technology'));
    };
    
    /** usesTraits lets us define traits to use */
    yield function () use ($trait) {
        $trait->usesTraits('PasswordGenerator', 'LoginScript');
        $result = $trait->render();
        assert(strpos($result, 'use PasswordGenerator'));
        assert(strpos($result, 'use LoginScript'));
    };
    
    /** defineProperty lets us set properties with visibility of our choice */
    yield function () use ($trait) {
        $trait->defineProperty('user', null, 'private');
        $result = $trait->render();
        assert(strpos($result, 'private $user'));
    };
    
    /** addMethod lets us create a method and allows us to retrieve it */
    yield function () use ($trait) {
        $trait->addMethod('login', function (string $user, string $pass) : bool {}, function ($method) {
            $method->setBody(<<<EOT
        if (\$user === 'test' && \$pass === 'blarps') {
    return true;
} else {
    return false;
}
EOT
            );
        });
        $result = $trait->getMethod('login')->render();
        assert(strpos($result, 'function login(string $user, string $pass) : bool'));
    };
};

