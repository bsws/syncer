<?php
namespace Service;

use Entity\Hotel as HotelEntity;
use Hydrator\Hotel as HotelHydrator;
use Metadata\Hotel as HotelMetadata;
use Metadata\Description as DescriptionMetadata;
use Metadata\HotelRoom as HotelRoomMetadata;
use Comparer\Hotel as HotelComparer;

//@TODO - finish the work to complete the update of the hotel data and annexes

class Hotel extends Generic
{
    protected $providerData = null;
    protected $app = null;

    public function getProviderData()
    {
        return $this->providerData;
    }

    public function getNew()
    {
        $hotel = new HotelEntity();
        return $hotel;
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
    * translate a stdClass object to a Entity\Hotel object
    * 
    * $o - the object to be translated
    * $providerId - the id of the provider the hotel belongs to
    */
    public function translateFromStdObject($o, $providerId, $providerIdent)
    {
        $hydrator = HotelHydrator::getInstance($providerId, $providerIdent);
        $newObj = $hydrator->hydrate($o);
        return $newObj;
    }

    public function insertHotels($hotelsArr, $providerId)
    {
        foreach($hotelsArr as $h) {
            $this->insertHotel($h, $providerId);
        }

        //return void
    }

    public function getDbHotels($providerId)
    {
        $q = "SELECT * FROM hotel WHERE provider_id = '{$providerId}'";
        return $this->getDb()->fetchAll($q);
    }

    public function insertHotel($objToInsert)
    {
        $this->insertObject($objToInsert);

        //rooms
        foreach ($objToInsert->getRoomCategories() as $roomCategory) {
            $roomCategory->setProviderId($objToInsert->getProviderId());
            $roomCategory->setHotelId($objToInsert->getId());
            $this->getSilexApplication()['service.hotel_room']->insertRoomCategory($roomCategory);
        }

        //descriptions
        foreach ($objToInsert->getDetailedDescriptions() as $description) {
            $description->setProviderId($objToInsert->getProviderId());
            $description->setHotelId($objToInsert->getId());
            $this->getSilexApplication()['service.description']->insertDescription($description);
        }

        $this->getLogger()->info("The hotel with id {$objToInsert->getId()} was inserted.");

        return $objToInsert;
    }

    public function getHydrated($dataIn)
    {
        $providerData = $this->getProviderData();
        $hydrator = HotelHydrator::getInstance($providerData['id'], $providerData['ident']);
        $newObj = $hydrator->hydrate($dataIn);
        return $newObj;
    }

    function getHotelFromDb($providerId, $idAtProvider)
    {
        if(empty($providerId)) {
            throw new \Exception("No provider id specified for hotel object.");
        }

        if(empty($idAtProvider)) {
            throw new \Exception("No id at provider specified for hotel object.");
        }

        $q = $this->getSelectSql();
        $dbArr = $this->getDb()->fetchAll($q, ["provider_id" => $providerId, "id_at_provider" => $idAtProvider]);

        //hydrate
        $dbHotel = $this->getHydrated($dbArr);

        return $dbHotel;
    }

    protected function checkAndSync($hotel)
    {
        if(empty($hotel->getProviderId())) {
            throw new \Exception("No provider id specified for hotel object.");
        }

        if(empty($hotel->getIdAtProvider())) {
            throw new \Exception("No id at provider specified for hotel object.");
        }

        //search for the object in DB
        $dbHotel = $this->getHotelFromDb($hotel->getProviderId(), $hotel->getIdAtProvider());
        $hotelDiff = HotelComparer::compare($hotel, $dbHotel);

        foreach ($hotelDiff as $key => $arr) {
            if(!empty($arr)) {
                if(!empty($arr["insert"])) {
                    //perform an insertion
                    foreach ($arr["insert"] as $objToInsert) {
                        if($objToInsert instanceof \Entity\Hotel) {
                            $this->insertHotel($objToInsert);
                            print("\r\nThe hotel with id {$objToInsert->getPkValue()} was inserted."); 
                        }
                    }
                    // die;
                }
                if(!empty($arr["update"])) {
                    //perform an update
                }
            }
        }

    }

    public function sync($hotelsArr, $providerId, $providerIdent)
    {
        try {
            foreach($hotelsArr as $data) {
                $this->checkAndSync($data);
            }
        } catch(\Exception $Ex) {
            echo $Ex->getMessage();
            die();
        }
    }

    public function getSelectSql()
    {
        $app = $this->getSilexApplication();
        $hotelAliasColumns = HotelMetadata::dbColumnsAliases();
        $roomTypeAliasColumns = HotelRoomMetadata::dbColumnsAliases();
        $descriptionAliasColumns = DescriptionMetadata::dbColumnsAliases();

        $cols = $hotelAliasColumns + $roomTypeAliasColumns + $descriptionAliasColumns;
        $colsCount = count($cols);

        $count = 0;

        $q = "
            SELECT 
                ";
            foreach($cols as $k => $v) {
                $q .= " $k  $v";
                if($count < $colsCount - 1) {
                    $q .= ", ";
                }
                $q .= "\r\n";

                $count ++;
            }
        $q .= " 
            FROM 
                ".HotelMetadata::$table." h
                LEFT JOIN ".HotelRoomMetadata::$table." hrc ON hrc.hotel_id = h.id
                LEFT JOIN ".DescriptionMetadata::$table." hdd ON hdd.hotel_id = h.id
            WHERE
                h.provider_id = :provider_id
                AND h.id_at_provider = :id_at_provider
        ";

        return $q;
    }

    public function getUnequalFields(\Entity\Hotel $providerHotel, \Entity\Hotel $dbHotel)
    {
        $unequalities = [];

        $equalsRoomCategories = true;

        $methods = get_class_methods($providerHotel);

        foreach($methods as $m) {
            if(substr($m, 0, 3) == "get") {
                if($m == "getId") continue;
                if($m == "getHotelTheme") continue;

                //room categories
                if($m == "getRoomCategories") {
                    $providerCol = $providerHotel->getRoomCategories();
                    $dbCol = $dbHotel->getRoomCategories();

                    $equalsRoomCategories = $this->app['service.hotel_room']->equalsCollections($providerCol, $dbCol);
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

                if($providerHotel->$m() != $dbHotel->$m()) {
                    //echo $m,". ", $hotel1->$m(), " - ", $hotel2->$m(),"\r\n";
                    $unequalities[] = $m;
                }
            }
        }

        return $unequalities;
    }

    public function syncRoomCategories($hotelObj, $providerRoomCategories)
    {
        return $this->app['service.hotel_room']->syncRoomCategoriesForHotel($hotelObj, $providerRoomCategories);
    }

    public function syncDetailedDescriptionsForHotel($hotelObj, $providerDetailedDescriptions)
    {
        return $this->app['service.description']->syncDetailedDescriptionsForHotel($hotelObj, $providerDetailedDescriptions);
    }


}
