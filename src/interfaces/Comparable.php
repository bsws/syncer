<?php
namespace Interfaces;

interface Comparable
{
    /**
    * this function compares two objects that inherits the \Entity\Generic class
    * @param \Entity\Generic $instance1
    * @param \Entity\Generic $instance2
    *
    * @return true | array of unequal fields
    **/
    public static function equalEntities(\Entity\Generic $instance1, \Entity\Generic $instance2);

    public static function compareCollections(array $col1, array $col2);
}
