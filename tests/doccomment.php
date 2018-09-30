<?php

use Gentry\Gentry\Wrapper;

class TraitHost extends Codger\Php\Recipe {
    use Codger\Php\Doccomment;

    protected $template = 'class.html.twig';
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
    
    /** appendDoccomment lets us add to an existing block */
    yield function () use ($trait) { 
        $trait->appendDoccomment(' but idgaf');
        $result = $trait->render();
        assert(strpos($result, '/** Work in progress but idgaf */'));
    };
};

