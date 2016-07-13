<?php
namespace Metadata;

class Description implements \Interfaces\Metadata
{
    public static $table = "hotel_detailed_description";

    public static function dbColumnsAliases()
    {
        return [
            'hdd.id' => 'hdd_id',
            'hdd.provider_id' => 'hdd_provider_id',
            'hdd.hotel_id' => 'hdd_hotel_id',
            'hdd.label' => 'hdd_label',
            'hdd.text' => 'hdd_text',
            'hdd.desc_index' => 'hdd_desc_index'
        ];
    }

    public static function comparableFields()
    {
        return [
            "label",
            "text",
            "desc_index"
        ];   
    }
}
