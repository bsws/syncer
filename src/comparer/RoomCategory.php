<?php
namespace Comparer;

use Interfaces\Comparable;
use Metadata\HotelRoom as HotelRoomMetadata;

class RoomCategory extends Generic implements Comparable
{
    public static function comparableFields()
    {
        return HotelRoomMetadata::comparableFields();
    }
}
