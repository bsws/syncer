<?php
namespace Metadata;

class HotelRoom implements \Interfaces\Metadata
{
    public static $table = "hotel_room_category";
    /**
    *  hotel room table column with aliases for select query
    */
    public static function dbColumnsAliases()
    {
        return [
            'hrc.id' => 'hrc_id',
            'hrc.id_at_provider' => 'hrc_id_at_provider',
            'hrc.hotel_id' => 'hrc_hotel_id',
            'hrc.name' => 'hrc_name',
            'hrc.description' => 'hrc_description'
        ];
    }

    /**
    * return an array of fields => method name array
    **/
    public static function getComparableFields()
    {
        return [
            'name' => 'getName',
            'description' => 'getDescription',
            'Images' => 'getImages'
        ];
    }
}
