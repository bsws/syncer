<?php
namespace Hydrator;

use Interfaces\Hydrators;
use Entity\Package as PackageEntity;

class PackageChristiantour implements Hydrators
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
        $newObj = new PackageEntity();
        $newObj->setProviderId($this->getProviderId());
        $detailedDescriptionHydrator = DetailedDescription::getInstance();

        if(is_array($inData)) {

            $hydrated = [
                "main" => false, 
                "departure_dates" => [], 
                "departure_points" => [],
                "price_sets" => [],
                "detailed_descriptions" => [],
                "fare_type" => []
            ];

            foreach($inData as $o) {
                if(!$hydrated["main"]) {
                    //main object
                    //$newObj->setId($o['h_id']);
                    //$newObj->setIdAtProvider($o['h_id_at_provider']);
                    //$newObj->setSource($o['h_source']);
                    //$newObj->setSourceId($o['h_source_id']);
                    //$newObj->setCode($o['h_code']);
                    //$newObj->setName($o['h_name']);
                    //$newObj->setStars($o['h_stars']);
                    //$newObj->setDescription($o['h_description']);
                    //$newObj->setAddress($o['h_address']);
                    //$newObj->setZip($o['h_zip']);
                    //$newObj->setPhone($o['h_phone']);
                    //$newObj->setFax($o['h_fax']);
                    //$newObj->setLocation($o['h_location']);
                    //$newObj->setUrl($o['h_url']);
                    //$newObj->setLatitude($o['h_latitude']);
                    //$newObj->setLongitude($o['h_longitude']);
                    //$newObj->setExtraClass($o['h_extra_class']);
                    //$newObj->setUseIndividually($o['h_use_individually']);
                    //$newObj->setUseOnPackages($o['h_use_on_packages']);
                    //$newObj->setPropertyType($o['h_property_type']);

                    $hydrated["main"] = true;
                }

                //if(!empty($o["hrc_id"]) && !in_array($o["hrc_id"], $hydrated["rooms"])) {
                //    $hotelRoom = $hotelRoomHydrator->hydrate($o);
                //    $newObj->addRoomCategory($hotelRoom);
                //    $hydrated["rooms"][] = $o["hrc_id"];
                //}

                //if(!empty($o["dd_id"]) && !in_array($o["dd_id"], $hydrated["detailed_descriptions"])) {
                //    $detailedDescription = $detailedDescriptionHydrator->hydrate($o);
                //    $newObj->addDetailedDescription($detailedDescription);
                //    $hydrated["detailed_descriptions"][] = $o["dd_id"];
                //}
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
            $newObj->setProviderId($this->getProviderId());
            $newObj->setIdAtProvider($o->Id);
            $newObj->setName($o->Name);
            $newObj->setIsTour($o->IsTour);
            $newObj->setIsBus($o->IsBus);
            $newObj->setIsFlight($o->IsFlight);
            $newObj->setDuration($o->Duration);
            $newObj->setOutboundTransportDuration($o->OutboundTransportDuration);
            $newObj->setDescription($o->Description);
            $newObj->setDestinationId($o->Destination);
            $newObj->setIncludedServices($o->IncludedServices);
            $newObj->setNotIncludedServices($o->NotIncludedServices);
            $newObj->setHotelId($o->Hotel);
            $newObj->setHotelSourceId($o->HotelSource);
            $newObj->setCurrencyId($o->Currency);

            //relations 
            $DepartureDates= [];
            foreach($o->DepartureDates as $depDate) {
                $DepartureDates[] = $depDate;
            }
            $newObj->setDepartureDates($DepartureDates);

            $DeparturePoints= [];
            foreach($o->DeparturePoints as $depPoint) {
                $DeparturePoints[] = $depPoint;
            }
            $newObj->setDeparturePoints($DeparturePoints);

            $PriceSets = [];
            foreach($o->PriceSets as $stdPriceSet) {
                $PriceSets[] = $priceSetsHydrator->hydrate($stdPriceSet);
            }
            $newObj->setPriceSets($PriceSets);

            $DetailedDescriptions = [];
            foreach($o->DetailedDescriptions as $stdDetailedDescription) {
                $DetailedDescriptions[] = $detailedDescriptionHydrator->hydrate($stdDetailedDescription);
            }
            $newObj->setDetailedDescriptions($DetailedDescriptions);

            //$newObj->setFareType($o->RoomAmenities);
        } else {
            throw new \Exception("This is not treated.");
        }


        return $newObj;
    }
}
