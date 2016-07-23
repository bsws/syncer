<?php
die("this file is used anywhere? ".__FILE__.__LINE__);
namespace Service;

use Entity\HotelRoom as HotelRoomEntity;
use Hydrator\HotelRoom as HotelRoomHydrator;
use Metadata\HotelRoom as HotelRoomMetadata;

class HotelRoom extends Generic
{
    public function getNew()
    {
        $hotelRoom = new HotelRoomEntity();
        return $hotelRoom;
    }

    public function equalsCollections($providerCol, $dbCol)
    {
        if(is_array($providerCol) && is_array($dbCol)) {
            //if(count($providerCol) !== count($dbCol)) return false;

            foreach($providerCol as $providerRoom) {
                $roomExists = false;
                array_map(function($elem) use ($roomExists, $providerRoom) { 
                    if($providerRoom->getIdAtProvider() == $elem->getIdAtProvider()) $roomExists = true;
                }, $providerCol);

                if(!$roomExists) return false;
            }
        }

        return true;
    }

    public function insertRoom($RoomCategory)
    {
        if(!$RoomCategory->getHotelId()) throw new \Exception("Cannot insert into DB a room without hotelId");
        $arr = $RoomCategory->toArray();
        $insertId = $this->getDb()->insert("hotel_room_category", $arr);
        $RoomCategory->setId($insertId);

        return $RoomCategory;
    }

    public function syncRoomCategoriesForHotel($hotelObj, $providerRoomCategories)
    {
        if(!$hotelObj->getId()) throw new \Exception("Cannot sync the room categories for a hotel without ID");

        $roomsToInsert = [];
        $roomsToUpdate = [];

        foreach($providerRoomCategories as $room) {
            $roomInCollection = false;
            $roomToUpdate = false;
            array_map(function($elem) use ($room, &$roomInCollection, &$roomToUpdate) { 
                if(!empty($elem->getId()) && $room->getIdAtProvider() === $elem->getIdAtProvider()) {
                    $roomInCollection = true;

                    if(
                        $room->getName() !== $elem->getName()
                        || $room->getDescription() !== $elem->getDescription()
                        ) {
                        $roomToUpdate = true;
                    }
                }
            }, $hotelObj->getRoomCategories());

            if(!$roomInCollection) $roomsToInsert[] = $room;
            if($roomToUpdate) $roomsToUpdate[] = $room;
        }

        if(!empty($roomsToInsert)) {
            foreach($roomsToInsert as $r) {
                if(empty($r->getHotelId())) {
                    $r->setHotelId($hotelObj->getId());
                }
                $this->insertRoom($r);
            }
        }

        if(!empty($roomsToUpdate)) {
            die("xxxx: ".__FILE__." -> ".__LINE__);
        }
    }

    public function translateFromStdObjects(array $objsToTranslate, $providerId, $providerIdent)
    {
        $retArr = [];
        if(is_array($objsToTranslate) && count($objsToTranslate) > 0) 
        {
            foreach($objsToTranslate as $o) {
                $retArr[] = $this->translateFromStdObject($o, $providerId, $providerIdent);
            }
        }

        return $retArr;
    }
    /**
    * translate a stdClass object to a Entity\HotelRoom object
    * 
    * $o - the object to be translated
    * $providerId - the id of the provider the hotel belongs to
    */
    public function translateFromStdObject($o, $providerId, $providerIdent)
    {
        ######################################
        echo "RoomCategory to hydrate: \r\n";
        echo '<div style="color:red;background-color:yellow;">'.__FILE__.':'.__LINE__.'</div>';
        echo '<pre>';
        print_r($o);
        echo '</pre>';
        die;
        ######################################
        $hydrator = HotelRoomHydrator::getInstance($providerId, $providerIdent);
        $newObj = $hydrator->hydrate($o);
        return $newObj;
    }

}
