<?php

use Codger\Php\Interfaze;

$interface = new Interfaze(['Test']);

/** Test Interfaze */
return function () use ($interface) : Generator {
    /** setNamespace sets a namespace for our interface */
    yield function () use ($interface) {
        $interface->setNamespace('Unittest');
        $result = $interface->render();
        assert(strpos($result, 'namespace Unittest') !== false);
    };
    
    /** usesNamespaces lets us use a namespace */
    yield function () use ($interface) {
        $interface->usesNamespaces('Tools');
        $result = $interface->render();
        assert(strpos($result, 'use Tools') !== false);
    };
    
    /** setName lets us name our interface */
    yield function () use ($interface) {
        $interface->setName('Technology');
        $result = $interface->render();
        assert(strpos($result, 'interface Technology') !== false);
    };
    
    /** extendsClass lets our interface extend another */
    yield function () use ($interface) {
        $interface->extendsClass('Work');
        $result = $interface->render();
        assert(strpos($result, 'interface Technology extends Work') !== false);
    };
    
    /** definesConstants lets us set constants */
    yield function () use ($interface) {
        $interface->definesConstants(['host' => 'localhost']);
        $result = $interface->render();
        assert(strpos($result, "const host = 'localhost'") !== false);
    };
    
    /** addMethod lets us create a method and allows us to retrieve it */
    yield function () use ($interface) {
        $interface->addMethod('login', function (string $user, string $pass) : bool {}, function () {});
        $result = $interface->getMethod('login')->render();
        assert(strpos($result, 'function login(string $user, string $pass) : bool;') !== false);
    };
};

