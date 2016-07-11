<?php
namespace Comparer;

use Interfaces\Comparable;

use Comparer\RoomCategory as RoomCategoryComparer;
use Comparer\Generic as GenericComparer;

class Hotel extends GenericComparer implements Comparable
{
    public static function compare(/*provider object*/\Entity\Generic $instance1, \Entity\Generic $instance2)
    {
        //compare the main methods
        $unequalities = [];
        $equalsRoomCategories = true;
        $methods = get_class_methods($instance1);

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
                    ######################################
                    echo '<div style="color:red;background-color:yellow;">'.__FILE__.':'.__LINE__.'</div>';
                    echo '<pre>';
                    print_r($equalsRoomCategories);
                    echo '</pre>';
                    die;
                    ######################################
                    if(!$equalsRoomCategories) $unequalities[] = "getRoomCategories";

                    continue;
                }

                if($m == "getDetailedDescriptions") {
                    $providerCol = $providerHotel->getDetailedDescriptions();
                    $dbCol = $dbHotel->getDetailedDescriptions();

                    $equalsCollections = $this->app['service.description']->equalsCollections($providerCol, $dbCol);
                    if(!$equalsCollections) $unequalities[] = "getDetailedDescriptions";

                    continue;

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

        return $unequalities;
    }

    public static function compareCollections(array $col1, array $col2)
    {

    }
}
