<?php

use Codger\Php\Composer;

$composer = new Composer;

/** Test Composer */
return function () use ($composer) : Generator {
    $this->beforeEach(function () use (&$dir) {
        $dir = getcwd();
        chdir(getcwd().'/tmp');
        file_put_contents(getcwd().'/composer.json', <<<EOT
{
    "name": "codger/dummy",
    "description": "Dummy config.json",
    "type": "project",
    "license": "MIT",
    "authors": [
        {
            "name": "Marijn Ophorst",
            "email": "marijn@monomelodies.nl"
        }
    ],
    "require": {}
}
EOT
        );
    });
    $this->afterEach(function () use (&$dir) {
        chdir($dir);
    });
    /** hasDependency can verify if we have a certain dependency */
    yield function () use ($composer) : void {
        $result = $composer->hasDependency('codger/generate');
        assert($result === true);
    };
    /** addDependency can add a dependency to `require-dev` */
    yield function () use ($composer) : void {
        $composer->addDependency('monolyth/frontal', true);
        $c = json_decode(file_get_contents('composer.json'));
        assert(isset($c->{'require-dev'}));
        assert(isset($c->{'require-dev'}->{'monolyth/frontal'}));
    };
    /** addDependency can add a dependency to `require` */
    yield function () use ($composer) : void {
        $composer->addDependency('monolyth/frontal');
        $c = json_decode(file_get_contents('composer.json'));
        assert(isset($c->require));
        assert(isset($c->require->{'monolyth/frontal'}));
    };

    /** addVcsRepository adds a repository */
    yield function () use ($composer) : void {
        $composer->addVcsRepository('blarps', 'ssh://git@sensimedia.nl/home/git/libraries/sensi/blarps');
        $c = json_decode(file_get_contents('composer.json'));
        assert(isset($c->repositories));
        assert(isset($c->repositories->blarps));
        assert($c->repositories->blarps->type === 'vcs');
        assert($c->repositories->blarps->url === 'ssh://git@sensimedia.nl/home/git/libraries/sensi/blarps');
    };
};

