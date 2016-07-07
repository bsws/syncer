<?php
namespace Metadata;

class Hotel implements \Interfaces\Metadata
{
    public static $table = 'hotel';

    public static function dbColumnsAliases()
    {
        return [
            'h.id' => 'h_id',
            'h.provider_id' => 'h_provider_id',
            'h.id_at_provider' => 'h_id_at_provider',
            'h.source' => 'h_source',
            'h.source_id' => 'h_source_id',
            'h.code' => 'h_code',
            'h.name' => 'h_name',
            'h.stars' => 'h_stars',
            'h.description' => 'h_description',
            'h.address' => 'h_address',
            'h.zip' => 'h_zip',
            'h.phone' => 'h_phone',
            'h.fax' => 'h_fax',
            'h.location' => 'h_location',
            'h.url' => 'h_url',
            'h.latitude' => 'h_latitude',
            'h.longitude' => 'h_longitude',
            'h.extra_class' => 'h_extra_class',
            'h.use_individually' => 'h_use_individually',
            'h.use_on_packages' => 'h_use_on_packages',
            'h.property_type' => 'h_property_type',
        ];
    }

}
