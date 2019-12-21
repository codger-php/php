<?php

namespace Codger\Php;

trait Quote
{
    /**
     * Internal helper to properly quote a value.
     *
     * @param string|null $unquoted
     * @return string
     */
    protected function quote(string $unquoted = null) : string
    {
        if (is_null($unquoted)) {
            return 'null';
        }
        if (is_numeric($unquoted)) {
            return (string)$unquoted;
        }
        if (in_array($unquoted, ['true', 'false'])) {
            return $unquoted;
        }
        return "'".str_replace("'", "\'", $unquoted)."'";
    }
}

