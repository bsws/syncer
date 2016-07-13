<?php
namespace Comparer;

use Interfaces\Comparable;

use Comparer\RoomCategory as RoomCategoryComparer;
use Comparer\DetailedDescription as DetailedDescriptionComparer;

class Hotel extends Generic implements Comparable
{

    public static function compare(/*provider object*/\Entity\Generic $providerInstance, \Entity\Generic $dbInstance)
    {
        $hotelFinalData = [
            "hotel" => [],
            "Rooms" => [],
            "DetailedDescriptions" => [],
            "Images" => [],
            "HotelAmenities" => [],
            "RoomAmenities" => []

        ];

        //compare the hotel instances
        $hotelDiff = self::equalEntities($providerInstance, $dbInstance);
        if(true !== $hotelDiff) {
            $hotelFinalData["hotel"][(-1 === $hotelDiff) ? "insert" : "update"][] = $providerInstance;
        }

        if(-1 === $hotelDiff) {
            return $hotelFinalData;
        }

        //compare the main methods
        $equalsRoomCategories = true;
        $methods = get_class_methods($providerInstance);

        foreach($methods as $m) {
            if(substr($m, 0, 3) == "get") {

                //skip some methods for now
                if($m == "getId") continue;
                if($m == "getHotelTheme") continue;

                //room categories
                if($m == "getRoomCategories") {
                    $providerCollection = $providerInstance->getRoomCategories();
                    $dbCollection = $dbInstance->getRoomCategories();

                    $equalsRoomCategories = RoomCategoryComparer::compareCollections($providerCollection, $dbCollection);//$this->app['service.hotel_room']->equalsCollections($providerCol, $dbCol);
                    if(true !== $equalsRoomCategories) $hotelFinalData["Rooms"] = $equalsRoomCategories;

                    continue;
                }

                if($m == "getDetailedDescriptions") {
                    $providerCollection = $providerInstance->getDetailedDescriptions();
                    $dbCollection = $dbInstance->getDetailedDescriptions();
                    $equalsDetailedDescriptions = DetailedDescriptionComparer::compareCollections($providerCollection, $dbCollection);

                    if(true !== $equalsDetailedDescriptions) $hotelFinalData["DetailedDescriptions"] = $equalsDetailedDescriptions;

                    continue;
                }
                

                if(in_array( $m, ["getImages", "getHotelAmenities", "getRoomAmenities"])) {
                    continue;
                } 

                if($providerInstance->$m() != $dbInstance->$m()) {
                    //echo $m,". ", $hotel1->$m(), " - ", $hotel2->$m(),"\r\n";
                    $unequalities[] = $m;
                }
            }
        }

        return $hotelFinalData;
    }

    public static function comparableFields()
    {
        return \Metadata\Hotel::comparableFields();
    }

}
