<?php
namespace Hydrator;

use Interfaces\Hydrators;
use Entity\Hotel as HotelEntity;

class HotelChristiantour implements Hydrators
{
    protected $providerId;

    public function __construct($providerId)
    {
        $this->providerId = $providerId;
    }

    public function getProviderId()
    {
        return $this->providerId;
    }

    public function hydrate($inData/* source */) {
        //return new hotel object

        //use a factory in the future
        $newObj = new HotelEntity();
        $newObj->setProviderId($this->getProviderId());

        $hotelRoomHydrator = HotelRoom::getInstance();
        $imagesHydrator = Image::getInstance();
        $detailedDescriptionHydrator = DetailedDescription::getInstance();

        if(is_array($inData)) {

            $hydrated = ["main" => false, "rooms" => [], "detailed_descriptions" => []];

            foreach($inData as $o) {
                if(!$hydrated["main"]) {
                    //main object
                    $newObj->setId($o['h_id']);
                    $newObj->setIdAtProvider($o['h_id_at_provider']);
                    $newObj->setSource($o['h_source']);
                    $newObj->setSourceId($o['h_source_id']);
                    $newObj->setCode($o['h_code']);
                    $newObj->setName($o['h_name']);
                    $newObj->setStars($o['h_stars']);
                    $newObj->setDescription($o['h_description']);
                    $newObj->setAddress($o['h_address']);
                    $newObj->setZip($o['h_zip']);
                    $newObj->setPhone($o['h_phone']);
                    $newObj->setFax($o['h_fax']);
                    $newObj->setLocation($o['h_location']);
                    $newObj->setUrl($o['h_url']);
                    $newObj->setLatitude($o['h_latitude']);
                    $newObj->setLongitude($o['h_longitude']);
                    $newObj->setExtraClass($o['h_extra_class']);
                    $newObj->setUseIndividually($o['h_use_individually']);
                    $newObj->setUseOnPackages($o['h_use_on_packages']);
                    $newObj->setPropertyType($o['h_property_type']);

                    $hydrated["main"] = true;
                }

                if(!empty($o["hrc_id"]) && !in_array($o["hrc_id"], $hydrated["rooms"])) {
                    $hotelRoom = $hotelRoomHydrator->hydrate($o);
                    $newObj->addRoomCategory($hotelRoom);
                    $hydrated["rooms"][] = $o["hrc_id"];
                }

                if(!empty($o["dd_id"]) && !in_array($o["dd_id"], $hydrated["detailed_descriptions"])) {
                    $detailedDescription = $detailedDescriptionHydrator->hydrate($o);
                    $newObj->addDetailedDescription($detailedDescription);
                    $hydrated["detailed_descriptions"][] = $o["dd_id"];
                }
            }

            //aux

            //$newObj->setRoomCategories();
            //$newObj->setImages($o['']);
            //$newObj->setDetailedDescriptions($o['']);
            //$newObj->setHotelTheme($o['']);
            //$newObj->setHotelAmenities($o['']);
            //$newObj->setRoomAmenities($o['']);

        } elseif($inData instanceof \stdClass) {
            $o = $inData;
            $newObj->setIdAtProvider($o->Id);
            $newObj->setSource($o->Source);
            $newObj->setSourceId($o->SourceId);
            $newObj->setCode($o->Code);
            $newObj->setName($o->Name);
            $newObj->setStars($o->Class);
            $newObj->setDescription($o->Description);
            $newObj->setAddress($o->Address);
            $newObj->setZip($o->ZIP);
            $newObj->setPhone($o->Phone);
            $newObj->setFax($o->Fax);
            $newObj->setLocation($o->Location);
            $newObj->setUrl($o->URL);
            $newObj->setLatitude($o->Latitude);
            $newObj->setLongitude($o->Longitude);
            $newObj->setExtraClass($o->ExtraClass);
            $newObj->setUseIndividually($o->UseIndividually);
            $newObj->setUseOnPackages($o->UseOnPackages);
            $newObj->setPropertyType($o->PropertyType);

            //relations 
            $RoomCategories = [];
            foreach($o->RoomCategories as $stdRoomCategory) {
                $RoomCategories[] = $hotelRoomHydrator->hydrate($stdRoomCategory);
            }
            $newObj->setRoomCategories($RoomCategories);

            $Images = [];
            foreach($o->Images as $stdImage) {
                $Images[] = $imagesHydrator->hydrate($stdImage);
            }
            $newObj->setImages($Images);

            $DetailedDescriptions = [];
            foreach($o->DetailedDescriptions as $stdDetailedDescription) {
                $DetailedDescriptions[] = $detailedDescriptionHydrator->hydrate($stdDetailedDescription);
            }
            $newObj->setDetailedDescriptions($DetailedDescriptions);

            $newObj->setHotelTheme($o->HotelTheme);
            $newObj->setHotelAmenities($o->HotelAmenities);
            $newObj->setRoomAmenities($o->RoomAmenities);
        } else {
            throw new \Exception("This is not treated.");
        }


        return $newObj;
    }
}
