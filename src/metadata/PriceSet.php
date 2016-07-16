<?php
namespace Metadata;

class PriceSet implements \Interfaces\Metadata
{
    public static $table = 'price_set';

    public static function dbColumnsAliases()
    {
        return [
            'ps.id'  => 'ps_id', 
            'ps.id_at_provider'  => 'ps_id_at_provider', 
            'ps.package_id' => 'ps_package_id', 
            'ps.title'    => 'ps_title', 
            'ps.description' => 'ps_description', 
            'ps.valid_from'  => 'ps_valid_from', 
            'ps.valid_to'   => 'ps_valid_to', 
            'ps.travel_from'    => 'ps_travel_from', 
            'ps.travel_to' => 'ps_travel_to'
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
