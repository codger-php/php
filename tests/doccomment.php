<?php

use Gentry\Gentry\Wrapper;

class TraitHost extends Codger\Php\Recipe {
    protected $template = 'class.html.twig';
    use Codger\Php\Doccomment;
}

$trait = Wrapper::createObject(TraitHost::class);

/** Doccomment test */
return function () use ($trait) : Generator {
    /** setDoccomment lets us create one */
    yield function () use ($trait) { 
        $trait->setDoccomment('Work in progress');
        $result = $trait->render();
        assert(strpos($result, '/** Work in progress */'));
    };
};

