<?php
namespace Comparer;

use Interfaces\Comparable;

use Comparer\RoomCategory as RoomCategoryComparer;
use Comparer\DetailedDescription as DetailedDescriptionComparer;

class Hotel extends Generic implements Comparable
{

    public static function compare(\Entity\Generic $providerInstance, \Entity\Generic $dbInstance)
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
        $providerCollection = $providerInstance->getRoomCategories();
        $dbCollection = $dbInstance->getRoomCategories();
        ######################################
        echo '<div style="color:red;background-color:yellow;">'.__FILE__.':'.__LINE__.'</div>';
        echo '<pre>';
        print_r($dbInstance);
        print_r($providerCollection);
        print_r($dbCollection);
        echo '</pre>';
        die;
        ######################################

        $equalsRoomCategories = RoomCategoryComparer::compareCollections($providerCollection, $dbCollection);
        if(true !== $equalsRoomCategories) $hotelFinalData["Rooms"] = $equalsRoomCategories;

        $providerCollection = $providerInstance->getDetailedDescriptions();
        $dbCollection = $dbInstance->getDetailedDescriptions();
        $equalsDetailedDescriptions = DetailedDescriptionComparer::compareCollections($providerCollection, $dbCollection);

        if(true !== $equalsDetailedDescriptions) $hotelFinalData["DetailedDescriptions"] = $equalsDetailedDescriptions;


        return $hotelFinalData;
    }

    public static function comparableFields()
    {
        return \Metadata\Hotel::comparableFields();
    }

}
