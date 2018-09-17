<?php

use Gentry\Gentry\Wrapper;
use Codger\Php\Klass;
use Codger\Php\Method;

$klass = Wrapper::createObject(Klass::class);

/** Test Klass */
return function () use ($klass) : Generator {
    /** Test setNamespace method*/
    yield function () use ($klass) {
        $result = $klass->setNamespace('blarps');
        assert($result instanceof Klass);
    };
    
    /** Test usesNamespaces method*/
    yield function () use ($klass) {
        $result = $klass->usesNamespaces('blarps');
        assert($result instanceof Klass);
    };
    
    /** Test setName method*/
    yield function () use ($klass) {
        $result = $klass->setName('blarps');
        assert($result instanceof Klass);
    };
    
    /** Test isFinal method*/
    yield function () use ($klass) {
        $result = $klass->isFinal(true);
        assert($result instanceof Klass);
    };
    
    /** Test isAbstract method*/
    yield function () use ($klass) {
        $result = $klass->isAbstract(true);
        assert($result instanceof Klass);
    };
    
    /** Test extendsClass method*/
    yield function () use ($klass) {
        $result = $klass->extendsClass('blarps');
        assert($result instanceof Klass);
    };
    
    /** Test implementsInterfaces method*/
    yield function () use ($klass) {
        $result = $klass->implementsInterfaces('blarps');
        assert($result instanceof Klass);
    };
    
    /** Test usesTraits method*/
    yield function () use ($klass) {
        $result = $klass->usesTraits('blarps');
        assert($result instanceof Klass);
    };
    
    /** Test definesConstants method*/
    yield function () use ($klass) {
        $result = $klass->definesConstants(['text' => 'blarps']);
        assert($result instanceof Klass);
    };
    
    /** Test defineProperty method*/
    yield function () use ($klass) {
        $result = $klass->defineProperty('blarps');
        assert($result instanceof Klass);
    };
    
    /** Test addMethod method*/
    yield function () use ($klass) {
        $result = $klass->addMethod('blarps', function () { return 'blarps'; });
        assert($result instanceof Klass);
    };
    
    /** Test getMethod method*/
    yield function () use ($klass) {
        $result = $klass->getMethod('blarps');
        assert($result instanceof Method);
    };
    
    /** Test render method*/
    yield function () use ($klass) {
        $result = $klass->render();
        assert(is_string($result));
    };
};

