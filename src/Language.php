<?php

namespace Codger\Php;

abstract class Language
{
    public static function pluralize(string $string) : string
    {
        switch (substr($string, -1)) {
            case 'y':
                return substr($string, 0,.-1).'ies';
            default:
                return "{$string}s";
        }
    }
}

