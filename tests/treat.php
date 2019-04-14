<?php

use Gentry\Gentry\Wrapper;
use Codger\Php\Treat;

$klass = Wrapper::createObject(Treat::class);

/** Test Treat */
return function () use ($klass) : Generator {
    /** setNamespace sets a namespace for our trait */
    yield function () use ($klass) {
        $klass->setNamespace('Unittest');
        $result = $klass->render();
        assert(strpos($result, 'namespace Unittest'));
    };
    
    /** usesNamespaces lets us use a namespace */
    yield function () use ($klass) {
        $klass->usesNamespaces('Tools');
        $result = $klass->render();
        assert(strpos($result, 'use Tools'));
    };
    
    /** setName lets us name our trait */
    yield function () use ($klass) {
        $klass->setName('Technology');
        $result = $klass->render();
        assert(strpos($result, 'trait Technology'));
    };
    
    /** isFinal lets us define a final trait */
    yield function () use ($klass) {
        $klass->isFinal(true);
        $result = $klass->render();
        assert(strpos($result, 'final trait Technology'));
    };
    
    /** isAbstract defines our trait as abstract */
    yield function () use ($klass) {
        $klass->isAbstract(true);
        $result = $klass->render();
        assert(strpos($result, 'final abstract trait Technology'));
    };
    
    /** extendsClass lets our trait extend another */
    yield function () use ($klass) {
        $klass->extendsClass('Work');
        $result = $klass->render();
        assert(strpos($result, 'final abstract trait Technology extends Work'));
    };
    
    /** implementsInterfaces lets us implement multiple interfaces */
    yield function () use ($klass) {
        $klass->implementsInterfaces('Secure', 'Fast');
        $result = $klass->render();
        assert(strpos($result, 'final abstract trait Technology extends Work implements Secure, Fast'));
    };
    
    /** usesTraits lets us define traits to use */
    yield function () use ($klass) {
        $klass->usesTraits('PasswordGenerator', 'LoginScript');
        $result = $klass->render();
        assert(strpos($result, 'use PasswordGenerator'));
        assert(strpos($result, 'use LoginScript'));
    };
    
    /** definesConstants lets us set constants */
    yield function () use ($klass) {
        $klass->definesConstants(['host' => 'localhost']);
        $result = $klass->render();
        assert(strpos($result, "const host = 'localhost'"));
    };
    
    /** defineProperty lets us set properties with visibility of our choice */
    yield function () use ($klass) {
        $klass->defineProperty('user', null, 'private');
        $result = $klass->render();
        assert(strpos($result, 'private $user'));
    };
    
    /** addMethod lets us create a method and allows us to retrieve it */
    yield function () use ($klass) {
        $klass->addMethod('login', function (string $user, string $pass) : bool {}, function ($method) {
            $method->setBody(<<<EOT
        if (\$user === 'test' && \$pass === 'blarps') {
    return true;
} else {
    return false;
}
EOT
            );
        });
        $result = $klass->getMethod('login')->render();
        assert(strpos($result, 'function login(string $user, string $pass) : bool'));
    };
};
