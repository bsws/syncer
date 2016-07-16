<?php
namespace Metadata;

class Departure implements \Interfaces\Metadata
{
    public static $table = 'departure';

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
