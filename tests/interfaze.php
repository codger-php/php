<?php

use Gentry\Gentry\Wrapper;
use Codger\Php\Interfaze;

$klass = Wrapper::createObject(Interfaze::class);

/** Test Interfaze */
return function () use ($klass) : Generator {
    /** setNamespace sets a namespace for our interface */
    yield function () use ($klass) {
        $klass->setNamespace('Unittest');
        $result = $klass->render();
        assert(strpos($result, 'namespace Unittest') !== false);
    };
    
    /** usesNamespaces lets us use a namespace */
    yield function () use ($klass) {
        $klass->usesNamespaces('Tools');
        $result = $klass->render();
        assert(strpos($result, 'use Tools') !== false);
    };
    
    /** setName lets us name our interface */
    yield function () use ($klass) {
        $klass->setName('Technology');
        $result = $klass->render();
        assert(strpos($result, 'interface Technology') !== false);
    };
    
    /** extendsClass lets our interface extend another */
    yield function () use ($klass) {
        $klass->extendsClass('Work');
        $result = $klass->render();
        assert(strpos($result, 'interface Technology extends Work') !== false);
    };
    
    /** definesConstants lets us set constants */
    yield function () use ($klass) {
        $klass->definesConstants(['host' => 'localhost']);
        $result = $klass->render();
        assert(strpos($result, "const host = 'localhost'") !== false);
    };
    
    /** addMethod lets us create a method and allows us to retrieve it */
    yield function () use ($klass) {
        $klass->addMethod('login', function (string $user, string $pass) : bool {}, function () {});
        $result = $klass->getMethod('login')->render();
        assert(strpos($result, 'function login(string $user, string $pass) : bool;') !== false);
    };
};

