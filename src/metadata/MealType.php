<?php
namespace Metadata;

class MealType implements \Interfaces\Metadata
{
    public static $table = 'meal_type';

    public static function dbColumnsAliases()
    {
        return [
            'mt.id' => 'mt_id',
            'mt.title' => 'mt_title',
        ];
    }

    public static function comparableFields()
    {
        return [
            'title'
        ];
    }

}
