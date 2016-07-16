<?php
namespace Metadata;

class MealPlan implements \Interfaces\Metadata
{
    public static $table = 'meal_plan';

    public static function dbColumnsAliases()
    {
        return [
            'mp.id' => 'mp_id',
            'mp.title' => 'mp_title',
        ];
    }

    public static function comparableFields()
    {
        return [
            'title'
        ];
    }

}
