<?php
namespace Metadata;

class Package implements \Interfaces\Metadata
{
    public static $table = 'package';

    public static function dbColumnsAliases()
    {
        return [
            'p.id'  => 'p_id', 
            'p.provider_id' => 'p_provider_id', 
            'p.id_at_provider'  => 'p_id_at_provider', 
            'p.name'    => 'p_name', 
            'p.is_tour' => 'p_is_tour', 
            'p.is_bus'  => 'p_is_bus', 
            'p.is_flight'   => 'p_is_flight', 
            'p.duration'    => 'p_duration', 
            'p.outbound_transport_duration' => 'p_outbound_transport_duration', 
            'p.description' => 'p_description',
            'p.destination_id'  => 'p_destination_id', 
            'p.included_services'   => 'p_included_services', 
            'p.not_included_services'   => 'p_not_included_services', 
            'p.hotel_id'    => 'p_hotel_id', 
            'p.hotel_source_id' => 'p_hotel_source_id', 
            'p.currency_id' => 'p_currency_id'
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
