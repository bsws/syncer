<?php
namespace Metadata;

class PackageDepartureDate
{
    public static $table = 'package_departure_date';

    public function dbColumnsAliases()
    {
        return [
            "pdd.package_id" => "pdd_package_id",
            "pdd.departure_date_id" => "pdd_departure_date_id"
        ];
    }

}
