<?php

use Gentry\Gentry\Wrapper;
use Codger\Php\Composer;

$composer = Wrapper::createObject(Composer::class);

/** Test Composer */
return function () use ($composer) : Generator {
    /** hasDependency can verify if we have a certain dependency  */
    yield function () use ($composer) {
        $result = $composer->hasDependency('codger/generate');
        assert($result === true);
    };
};

