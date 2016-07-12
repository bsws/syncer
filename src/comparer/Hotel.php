<?php
namespace Comparer;

use Interfaces\Comparable;

use Comparer\RoomCategory as RoomCategoryComparer;
use Comparer\DetailedDescription as DetailedDescriptionComparer;

class Hotel extends Generic implements Comparable
{

    public static function compare(/*provider object*/\Entity\Generic $providerInstance, \Entity\Generic $dbInstance)
    {
        //compare the hotel instances
        $hotelDiff = self::equalEntities($providerInstance, $dbInstance);
        echo '<pre>';
        print_r($hotelDiff); 
        echo '</pre>'; 
        die;

        //compare the main methods
        $equalsRoomCategories = true;
        $methods = get_class_methods($instance1);

        $hotelFinalData = [
            "hotel" => [],
            "Rooms" => [],
            "DetailedDescriptions" => [],
            "Images" => [],
            "HotelAmenities" => [],
            "RoomAmenities" => []

        ];

        foreach($methods as $m) {
            if(substr($m, 0, 3) == "get") {

                //skip some methods for now
                if($m == "getId") continue;
                if($m == "getHotelTheme") continue;

                //room categories
                if($m == "getRoomCategories") {
                    $providerCol = $instance1->getRoomCategories();
                    $dbCol = $instance2->getRoomCategories();

                    $equalsRoomCategories = RoomCategoryComparer::compareCollections($providerCol, $dbCol);//$this->app['service.hotel_room']->equalsCollections($providerCol, $dbCol);
                    if(true !== $equalsRoomCategories) $hotelFinalData["Rooms"] = $equalsRoomCategories;

                    continue;
                }

                if($m == "getDetailedDescriptions") {
                    $providerCollection = $instance1->getDetailedDescriptions();
                    $dbCollection = $instance2->getDetailedDescriptions();
                    $equalsDetailedDescriptions = DetailedDescriptionComparer::compareCollections($providerCollection, $dbCollection);

                    if(true !== $equalsDetailedDescriptions) $hotelFinalData["DetailedDescriptions"] = $equalsDetailedDescriptions;

                    continue;
                echo '<pre>';   
                print_r($hotelFinalData); 
                echo '</pre>'; 
                die;
                }
                

                if(in_array( $m, ["getImages", "getHotelAmenities", "getRoomAmenities"])) {
                    continue;
                } 

                if($instance1->$m() != $instance2->$m()) {
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
