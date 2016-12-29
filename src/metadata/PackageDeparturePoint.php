<?php
namespace Metadata;

class PackageDeparturePoint
{
    public static $table = 'package_departure_point';
    public static $tableAlias = 'pdp';

    public function dbColumnsAliases()
    {
        return [
            self::$tableAlias.".package_id" => self::$tableAlias."_package_id",
            self::$tableAlias.".departure_point_id" => self::$tableAlias."_departure_point_id"
        ];
    }

}
