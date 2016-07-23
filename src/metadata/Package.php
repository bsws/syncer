<?php
namespace Metadata;

class Package implements \Interfaces\Metadata
{
    public static $table = 'package';
    public static $tableAlias = 'p';

    public static function dbColumnsAliases()
    {
        return [
            self::$tableAlias.'.id'  => self::$tableAlias.'_id', 
            self::$tableAlias.'.provider_id' => self::$tableAlias.'_provider_id', 
            self::$tableAlias.'.id_at_provider'  => self::$tableAlias.'_id_at_provider', 
            self::$tableAlias.'.name'    => self::$tableAlias.'_name', 
            self::$tableAlias.'.is_tour' => self::$tableAlias.'_is_tour', 
            self::$tableAlias.'.is_bus'  => self::$tableAlias.'_is_bus', 
            self::$tableAlias.'.is_flight'   => self::$tableAlias.'_is_flight', 
            self::$tableAlias.'.duration'    => self::$tableAlias.'_duration', 
            self::$tableAlias.'.outbound_transport_duration' => self::$tableAlias.'_outbound_transport_duration', 
            self::$tableAlias.'.description' => self::$tableAlias.'_description',
            self::$tableAlias.'.destination_id'  => self::$tableAlias.'_destination_id', 
            self::$tableAlias.'.included_services'   => self::$tableAlias.'_included_services', 
            self::$tableAlias.'.not_included_services'   => self::$tableAlias.'_not_included_services', 
            self::$tableAlias.'.hotel_id'    => self::$tableAlias.'_hotel_id', 
            self::$tableAlias.'.hotel_source_id' => self::$tableAlias.'_hotel_source_id', 
            self::$tableAlias.'.currency_id' => self::$tableAlias.'_currency_id'
        ];
    }

    public static function comparableFields()
    {
        return [
            'name', 
            'is_tour', 
            'is_bus', 
            'is_flight', 
            'duration', 
            'outbound_transport_duration', 
            'description',
            //'destination_id', 
            //'included_services', 
            //'not_included_services', 
            'hotel_id', 
            'hotel_source_id', 
            'currency_id'
        ];
    }

}
