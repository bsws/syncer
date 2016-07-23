<?php
namespace Metadata;

class PackageDepartureDate
{
    public static $table = 'package_departure_date';
    public static $tableAlias = 'pdd';

    public function dbColumnsAliases()
    {
        return [
            self::$tableAlias.".package_id" => self::$tableAlias."_package_id",
            self::$tableAlias.".departure_date_id" => self::$tableAlias."_departure_date_id"
        ];
    }

}
