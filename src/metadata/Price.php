<?php
namespace Metadata;

class Price implements \Interfaces\Metadata
{
    public static $table = 'prices';
    public static $tableAlias = 'pri';

    public static function dbColumnsAliases()
    {
        return [
            self::$tableAlias.'.id'  => self::$tableAlias.'_id', 
            self::$tableAlias.'.package_id' => self::$tableAlias.'_package_id', 
            self::$tableAlias.'.hotel_room_category_id'    => self::$tableAlias.'_hotel_room_category_id', 
            self::$tableAlias.'.price_set_id' => self::$tableAlias.'_price_set_id', 
            self::$tableAlias.'.departure_date_id'  => self::$tableAlias.'_departure_date_id', 
            self::$tableAlias.'.gross'   => self::$tableAlias.'_gross', 
            self::$tableAlias.'.tax'    => self::$tableAlias.'_tax', 
            self::$tableAlias.'.meal_plan_id' => self::$tableAlias.'_meal_plan_id',
            self::$tableAlias.'.inserted_at' => self::$tableAlias.'_inserted_at'
        ];
    }

    public static function comparableFields()
    {
        return [];
    }

    public static function insertDbFields()
    {
        return [
            'package_id', 
            'hotel_room_category_id', 
            'price_set_id', 
            'departure_date_id', 
            'gross', 
            'tax', 
            'meal_plan_id',
            'inserted_at'
        ];
    }

}
