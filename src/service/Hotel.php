<?php
namespace Service;

use Entity\Hotel as HotelEntity;
use Hydrator\Hotel as HotelHydrator;
use Metadata\Hotel as HotelMetadata;
use Metadata\Description as DescriptionMetadata;
use Metadata\HotelRoom as HotelRoomMetadata;
use Comparer\Hotel as HotelComparer;

use Cocur\Slugify\Slugify;

//@TODO - finish the work to complete the update of the hotel data and annexes

class Hotel extends Generic
{
    protected $providerData = null;
    protected $app = null;

    //id_at_provider -> local id
    protected $hotelsMap = [];

    public function getProviderData()
    {
        return $this->providerData;
    }

    public function getNew()
    {
        $hotel = new HotelEntity();
        return $hotel;
    }

    public function ensureProviderData($providerId = null)
    {
        if(empty($this->getProviderData)) {
            if(!empty($providerId)) {
                $this->setExtraParams(['providerData' => $this->getSilexApplication()['service.provider']->getProviderDataById($providerId)]);
                return;
            }
            throw new \Exception("This object has no provider data.");
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

        if($objToInsert->getIdAtProvider() == 6245) {
            ######################################
            echo '<div style="color:red;background-color:yellow;">'.__FILE__.':'.__LINE__.'</div>';
            echo '<pre>';
            print_r($objToInsert);
            echo '</pre>';
            ######################################
        }

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

        $this->ensureProviderData($providerId);

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
                    print("Should perform an update for id ". $hotel->getIdAtProvider() ."\r\n");
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

    public function buildHotelMap()
    {
        $dbHotels = $this->getDbHotels($this->getProviderData()['id']);
        foreach($dbHotels as $hotel) {
            if(empty($this->hotelsMap[$hotel['id_at_provider']])) {
                $this->hotelsMap[$hotel['id_at_provider']] = $hotel['id'];
            }
        }
    }

    public function getHotelsMap()
    {
        return $this->hotelsMap;
    }

    public function syncImages($hotelData)
    {
        $providerData = $this->getProviderData();
        $this->buildHotelMap();
        $this->getDb()->executeQuery("TRUNCATE table hotel_images;");
        try {
            foreach($hotelData as $data) {
                if(!empty($data->Images) && !empty($this->hotelsMap[$data->Id])/* || !empty($data->HotelAmenities)*/) {
                    $imagesQ = "INSERT INTO hotel_images(provider_id, id_at_provider, hotel_id, mime_type, name) VALUES ";
                    $valuesToBind = [];
                    foreach($data->Images as $imgData) {
                        //get hotel data from db
                        $imagesQ .= "({$providerData['id']}, {$imgData->Id}, {$this->hotelsMap[$data->Id]}, ?, ?),";
                        $valuesToBind[] = $imgData->MimeType;
                        $valuesToBind[] = $imgData->Name;
                    }
                    $imagesQ = rtrim($imagesQ, ",");
                    $conn = $this->getDb();
                    $stmt = $this->getDb()->prepare($imagesQ);
                    foreach($valuesToBind as $index => $value) {
                        $stmt->bindValue($index + 1, $value);
                    }
                    $stmt->execute();
                    echo "Inserted images for the hotel ".$data->Name."\n";
                }

            }
        } catch(\Exception $Ex) {
            echo $Ex->getMessage();
            die();
        }
    }

    public function slugifyHotels() 
    {
        try {
            $slugifier = new Slugify();
            $db = $this->getDb();
            $hotels = $db->fetchAll("SELECT h.id id, h.name name, d.name location FROM hotel h LEFT JOIN destination d ON h.location = d.id WHERE h.slug IS NULL");
            foreach($hotels as $k => $arr) {
                $slug = $slugifier->slugify($arr['name'].' '.$arr['location'] );
                $db->executeUpdate('UPDATE hotel SET slug = ? WHERE id = ?', [$slug, $arr['id']]);
            }
        } catch(\Exception $Ex) {
            echo $Ex->getMessage();
        }
    }

}
