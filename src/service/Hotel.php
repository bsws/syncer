<?php
namespace Service;

use Entity\Hotel as HotelEntity;
use Hydrator\Hotel as HotelHydrator;

//@TODO - finish the work to complete the update of the hotel data and annexes

class Hotel extends Generic
{
    protected $providerData = null;
    protected $app = null;

    public function setExtraParams($extraParams = [])
    {
        if(!empty($extraParams['providerData'])) {
            $this->providerData = $extraParams['providerData'];
        }
        if(!empty($extraParams['app'])) {
            $this->app = $extraParams['app'];
        }
    }

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
        $arrData = [
            'provider_id' => $objToInsert->getProviderId(),
            'id_at_provider' => $objToInsert->getIdAtProvider(),
            'source' => $objToInsert->getSource(),
            'source_id' => $objToInsert->getSourceId(),
            'code' => $objToInsert->getCode(),
            'name' => $objToInsert->getName(),
            'stars' => $objToInsert->getStars(),
            'description' => $objToInsert->getDescription(),
            'address' => $objToInsert->getAddress(),
            'zip' => $objToInsert->getZip(),
            'phone' => $objToInsert->getPhone(),
            'fax' => $objToInsert->getFax(),
            'location' => $objToInsert->getLocation(),
            'url' => $objToInsert->getUrl(),
            'latitude' => $objToInsert->getLatitude(),
            'longitude' => $objToInsert->getLongitude(),
            'extra_class' => $objToInsert->getExtraClass(),
            'use_individually' => $objToInsert->getUseIndividually(),
            'use_on_packages' => $objToInsert->getUseOnPackages(),
            'property_type' => $objToInsert->getPropertyType()
        ];

        $this->getDb()->insert('hotel', $arrData);
        $insertId = $this->getDb()->lastInsertId();

        $objToInsert->setId($insertId);

        //insert the room categories too
        $this->syncRoomCategories($objToInsert, $objToInsert->getRoomCategories());

        //insert the detailed descriptions too
        $this->syncDetailedDescriptionsForHotel($objToInsert, $objToInsert->getDetailedDescriptions());

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

        //

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
        $unequalFields = $this->getUnequalFields($hotel, $dbHotel);

        if(!empty($unequalFields)) {
            if(in_array("getIdAtProvider", $unequalFields)) {
                $hotel = $this->insertHotel($hotel);
                echo "The hotel with id {$hotel->getId()} was inserted.\r\n";
            } else {
                foreach($unequalFields as $method) {
                    if($method == "getRoomCategories") {
                        $this->syncRoomCategories($dbHotel, $hotel->getRoomCategories());
                    }

                    if($method == "getDetailedDescriptions") {
                        $this->syncDetailedDescriptionsForHotel($dbHotel, $hotel->getDetailedDescriptions());
                    }
                }
            }
        } 

        //insert the object
    }

    public function sync($hotelsArr, $providerId, $providerIdent)
    {
        $db = $this->getDb();

        try {
            foreach($hotelsArr as $data) {
                $this->checkAndSync($data);
            }
        } catch(\Exception $Ex) {
            echo $Ex->getMessage();
            die();
        }
    }
    
    /**
    *  hotel table column with aliases for select query
    */
    public function getAliasColumns()
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

    public function getSelectSql()
    {
        $app = $this->getSilexApplication();
        $hotelAliasColumns = $this->getAliasColumns();
        $roomTypeAliasColumns = $app['service.hotel_room']->getAliasColumns();
        $descriptionAliasColumns = $app['service.description']->getAliasColumns();

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
                hotel h
                LEFT JOIN hotel_room_category hrc ON hrc.hotel_id = h.id
                LEFT JOIN hotel_detailed_description dd ON dd.hotel_id = h.id
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
