<?php

use Codger\Php\Method;

$twig = new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__).'/templates'));

$method = new Method('login', $twig);

/** Test Method */
return function () use ($twig, $method) : Generator {
    /** setVisibility allows us to modify the visibility */
    yield function () use ($method) {
        $method->setVisibility('private');
        $result = $method->render();
        assert(strpos($result, 'private function login()') !== false);
        $method->setVisibility('protected');
        $result = $method->render();
        assert(strpos($result, 'protected function login()') !== false);
        $method->setVisibility('public');
        $result = $method->render();
        assert(strpos($result, 'public function login()') !== false);
    };
    
    /** isPrivate sets the visibility to private */
    yield function () use ($method) {
        $method->isPrivate();
        $result = $method->render();
        assert(strpos($result, 'private function login()') !== false);
    };
    
    /** isProtected sets the visibility to protected */
    yield function () use ($method) {
        $method->isProtected();
        $result = $method->render();
        assert(strpos($result, 'protected function login()') !== false);
    };
    
    /** isPublic sets the visibility to public */
    yield function () use ($method) {
        $method->isPublic();
        $result = $method->render();
        assert(strpos($result, 'public function login()') !== false);
    };
    
    /** isStatic sets our method to static */
    yield function () use ($method) {
        $method->isStatic();
        $result = $method->render();
        assert(strpos($result, 'public static function login()') !== false);
    };
    
    /** isFinal sets our method to final */
    yield function () use ($method) {
        $method->isFinal();
        $result = $method->render();
        assert(strpos($result, 'public final static function login()') !== false);
    };
    
    /** isAbstract sets our method to abstract */
    yield function () use ($method) {
        $method->isAbstract();
        $result = $method->render();
        assert(strpos($result, 'public final abstract static function login()') !== false);
    };
    
    /** setReturnType defines our return type */
    yield function () use ($method) {
        $method->setReturnType('string');
        $result = $method->render();
        assert(strpos($result, 'public final abstract static function login() : string') !== false);
    };
    
    /** setNullable allows the method to return null instead */
    yield function () use ($method) {
        $method->setNullable(true);
        $result = $method->render();
        assert(strpos($result, 'public final abstract static function login() :? string') !== false);
    };
    
    /** setBody lets us define the body of our method */
    yield function () use ($method) {
        $method->isAbstract(false);
        $method->setBody(<<<EOT
if ((1 +1) === 2) {
    return 'Hier komt ie sws ja';
} else {
    return null;
}
EOT
        );
        $result = $method->render();
        assert(strpos($result, 'if') !== false);
        assert(strpos($result, 'else') !== false);
    };    
    
    /** addArgument lets us set arguments for our method */
    yield function () use ($twig, $method) {
        class TestMethod extends Method {
            public function testMe(string $user) {
            }
        }
        $parameter = new ReflectionParameter([TestMethod::class, 'testMe'], 'user');
        $argument = new Codger\Php\Argument($twig, $parameter);
        $method->addArgument($argument);
        $result = $method->render();
        assert(strpos($result, 'public final static function login(string $user) :? string') !== false);
    };
    
    /** initFromClosure can retrieve information from a callable */
    yield function () use ($method) {
        $callable = function (string $user, string $pass = null) {};
        $result = $method->initFromClosure($callable)->render();
        assert(strpos($result, 'public final static function login(string $user, string $pass = null) :? string') !== false);
    };
};

