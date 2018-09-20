<?php

use Gentry\Gentry\Wrapper;
use Codger\Php\Method;

$twig = new Twig_Environment(new Twig_Loader_Filesystem(dirname(__DIR__).'/templates'));

$method = Wrapper::createObject(Method::class, 'login', $twig);

/** Test Method */
return function () use ($method) : Generator {
    /** setVisibility allows us to modify the visibility */
    yield function () use ($method) {
        $method->setVisibility('private');
        $result = $method->render();
        assert(strpos($result, 'private function login()'));
        $method->setVisibility('protected');
        $result = $method->render();
        assert(strpos($result, 'protected function login()'));
        $method->setVisibility('public');
        $result = $method->render();
        assert(strpos($result, 'public function login()'));
    };
    
    /** isPrivate sets the visibility to private */
    yield function () use ($method) {
        $method->isPrivate();
        $result = $method->render();
        assert(strpos($result, 'private function login()'));
    };
    
    /** isProtected sets the visibility to protected */
    yield function () use ($method) {
        $method->isProtected();
        $result = $method->render();
        assert(strpos($result, 'protected function login()'));
    };
    
    /** isPublic sets the visibility to public */
    yield function () use ($method) {
        $method->isPublic();
        $result = $method->render();
        assert(strpos($result, 'public function login()'));
    };
    
    /** isStatic sets our method to static */
    yield function () use ($method) {
        $method->isStatic();
        $result = $method->render();
        assert(strpos($result, 'public static function login()'));
    };
    
    /** isFinal sets our method to final */
    yield function () use ($method) {
        $method->isFinal();
        $result = $method->render();
        assert(strpos($result, 'public final static function login()'));
    };
    
    /** isAbstract sets our method to abstract */
    yield function () use ($method) {
        $method->isAbstract();
        $result = $method->render();
        assert(strpos($result, 'public final abstract static function login()'));
    };
    
    /** setReturnType defines our return type */
    yield function () use ($method) {
        $method->setReturnType('string');
        $result = $method->render();
        assert(strpos($result, 'public final abstract static function login() : string'));
    };
    
    /** setNullable allows the method to return null instead */
    yield function () use ($method) {
        $method->setNullable(true);
        $result = $method->render();
        assert(strpos($result, 'public final abstract static function login() :? string'));
    };
    
    /** setBody lets us define the body of our method */
    yield function () use ($method) {
        $method->setBody(<<<EOT
if ((1 +1) === 2) {
    return 'Hier komt ie sws ja';
} else {
    return null;
}
EOT
        );
        $result = $method->render();
        assert(strpos($result, 'if'));
        assert(strpos($result, 'else'));
    };    
};

