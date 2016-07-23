<?php
namespace Metadata;

class HotelRoom implements \Interfaces\Metadata
{
    public static $table = "hotel_room_category";
    public static $tableAlias = "hrc";
    /**
    *  hotel room table column with aliases for select query
    */
    public static function dbColumnsAliases()
    {
        return [
            self::$tableAlias.'.id' => self::$tableAlias.'_id',
            self::$tableAlias.'.id_at_provider' => self::$tableAlias.'_id_at_provider',
            self::$tableAlias.'.hotel_id' => self::$tableAlias.'_hotel_id',
            self::$tableAlias.'.name' => self::$tableAlias.'_name',
            self::$tableAlias.'.description' => self::$tableAlias.'_description'
        ];
    }

    /**
    * return an array of fields => method name array
    **/
    public static function comparableFields()
    {
        return [
            'name',
            'description'
        ];
    }
}
