<?php 
namespace Util;

class String
{
    public static function dashToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $string = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $string[0] = strtolower($string[0]);
        }

        return $string;
    }
}