<?php
namespace Metadata;

class DepartureDate implements \Interfaces\Metadata
{
    public static $table = 'departure_date';

    public static function dbColumnsAliases()
    {
        return [
            'dep.id' => 'dep_id',
            'dep.at' => 'dep_at',
        ];
    }

    public static function comparableFields()
    {
        return [
            'at'
        ];
    }

}
