<?php
namespace Hydrator;

use Interfaces\Hydrators;
use Entity\RoomCategory as HotelRoomCategory;

class HotelRoomGeneric implements Hydrators
{
    public function hydrate($o/* source */) {
        //return new hotel room object

        //use a factory in the future
        $newObj = new HotelRoomCategory();

        if(is_array($o)) {
            if(!empty($o['hrc_id'])) {
                $newObj->setId($o['hrc_id']);
            }

            $newObj->setIdAtProvider($o['hrc_id_at_provider']);
            $newObj->setHotelId($o['hrc_hotel_id']);
            $newObj->setName($o['hrc_name']);
            $newObj->setDescription($o['hrc_description']);
            $newObj->setImages([]);
        } else {
            //$newObj->setId($o->Id);
            $newObj->setIdAtProvider($o->Id);
            if(!empty($o->HotelId)) {
                $newObj->setHotelId($o->HotelId);
            }
            $newObj->setName($o->Name);
            $newObj->setDescription($o->Description);
            $newObj->setImages([]);
        }


        return $newObj;
    }
}
