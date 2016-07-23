<?php
namespace Metadata;

class PriceSet implements \Interfaces\Metadata
{
    public static $table = 'price_set';
    public static $tableAlias = 'ps';

    public static function dbColumnsAliases()
    {
        return [
            self::$tableAlias.'.id'  => self::$tableAlias.'_id', 
            self::$tableAlias.'.id_at_provider'  => self::$tableAlias.'_id_at_provider', 
            self::$tableAlias.'.package_id' => self::$tableAlias.'_package_id', 
            self::$tableAlias.'.title'    => self::$tableAlias.'_title', 
            self::$tableAlias.'.description' => self::$tableAlias.'_description', 
            self::$tableAlias.'.valid_from'  => self::$tableAlias.'_valid_from', 
            self::$tableAlias.'.valid_to'   => self::$tableAlias.'_valid_to', 
            self::$tableAlias.'.travel_from'    => self::$tableAlias.'_travel_from', 
            self::$tableAlias.'.travel_to' => self::$tableAlias.'_travel_to'
        ];
    }

    public static function comparableFields()
    {
        return [
            'title', 
            'description', 
            'valid_from', 
            'valid_to', 
            'travel_from', 
            'travel_to'
        ];
    }

}
