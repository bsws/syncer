<?php
namespace Comparer;

class Generic 
{
    public static function equalEntities(\Entity\Generic $instance1, \Entity\Generic $instance2) {
        $comparableFields = EntityMetadata::getComparableFields();
        ######################################
        echo '<div style="color:red;background-color:yellow;">'.__FILE__.':'.__LINE__.'</div>';
        echo '<pre>';
        print_r($comparableFields);
        echo '</pre>';
        die;
        ######################################
    }
}
