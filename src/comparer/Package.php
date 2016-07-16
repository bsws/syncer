<?php
namespace Comparer;

use Comparer\PriceSet as PriceSetComparer;
use Comparer\DetailedDescription as DetailedDescriptionComparer;

class Package extends Generic
{
    public static function equalEntities(\Entity\Generic $providerInstance, \Entity\Generic $dbInstance)
    {
        $objFinalData = [
            "package" => [],
            "PriceSets" => [],
            "Departures" => [],
            "DetailedDescriptions" => []

        ];

        $objDiff = parent::equalEntities($providerInstance, $dbInstance);


        if(true !== $objDiff) {
            $objFinalData["package"][(-1 === $objDiff) ? "insert" : "update"][] = $providerInstance;
        }

        if(-1 === $objDiff) {
            return -1;
        }

        die('Check status');
        //price sets
        $priceSetsDiff = PriceSetComparer::compareCollections($providerInstance->getPriceSets(), $dbInstance->getPriceSets());
        if(!empty($providerInstance->getPriceSets())) {
            ######################################
            echo '<div style="color:red;background-color:yellow;">'.__FILE__.':'.__LINE__.'</div>';
            echo '<pre>';
            print_r($priceSetsDiff);
            echo '</pre>';
            die;
            ######################################
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
