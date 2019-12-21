<?php

namespace Codger\Php;

class Lambda extends BaseFunction
{
    /**
     * @return void
     */
    public function __invoke()
    {
        $this->output('anonymous-function.php');
    }
}

