<?php
namespace Service;

use Entity\Price as PriceEntity;
use Metadata\Price as PriceMetadata;

class Price extends Generic
{
    protected $hydrator;
    protected $depService = null;
    protected $mealPlanService = null;
    protected $packageService = null;
    protected $hotelRoomService = null;
    protected $priceSetService = null;

    protected $packageData = [];
    protected $hotelRoomData = [];
    protected $priceSetsData = [];

    public function getHydrator()
    {
        if(empty($this->hydrator)) {
            $providerData = $this->getProviderData();
            $depService = $this->getSilexApplication()["service.departure_date"];
            $this->hydrator = PackageHydrator::getInstance($providerData['id'], $providerData['ident'], $depService);
        }

        return $this->hydrator;
    }

    private function getNew()
    {
        return new PriceEntity();
    }

    private function ensurePopulatedServices()
    {
        $app = $this->getSilexApplication();
        if(empty($this->depService)) {
            $this->depService = $app['service.departure_date'];
        }

        if(empty($this->mealPlanService)) {
            $this->mealPlanService = $app['service.meal_plan'];
        }

        if(empty($this->packageService)) {
            $this->packageService = $app['service.package'];
        }

        if(empty($this->priceSetService)) {
            $this->priceSetService = $app['service.price_set'];
        }

        if(empty($this->hotelRoomService)) {
            $this->hotelRoomService = $app['service.hotel_room'];
        }
    }

    public function sync($pricesArr) 
    {
        $this->ensurePopulatedServices();
        $providerData = $this->getProviderData();
        $mealPlans = $this->mealPlanService->getAll();
        $departureDates = $this->depService->getAll();

        $packageOutputFields = ['p_id', 'p_hotel_id'];
        $packageInputFields = ['provider_id' => $providerData['id']];

        $roomOutputFields = ['hrc_id'];
        $roomInputFields = [];

        $priceSetOutputFields = ['ps_id'];
        $priceSetInputFields = [];

        foreach($pricesArr as $priceLine) {
            $lineArr = str_getcsv($priceLine);

            //resolve package id
            $providerPackageId = $lineArr[0];
            if(empty($this->packageData[$providerPackageId])) {
                $packageInputFields['id_at_provider'] = $providerPackageId;
                $packageData = $this->packageService->getPackageData($packageOutputFields, $packageInputFields);

                if(!empty($packageData)) {
                    $this->packageData[$providerPackageId] = ['id' => $packageData['p_id'], 'hotel_id' => $packageData['p_hotel_id']];
                }
            }

            //resolve room id
            $providerRoomId = $lineArr[1];
            if(!empty($this->packageData[$providerPackageId]) && empty($this->hotelRoomData[$providerRoomId])) {
                $roomInputFields = ['id_at_provider' => $providerRoomId];
                $hotelRoomData = $this->hotelRoomService->getHotelRoomData($roomOutputFields, $roomInputFields);
                if(!empty($hotelRoomData)) {
                    $this->hotelRoomData[$providerRoomId] = $hotelRoomData['hrc_id'];
                }
            }

            //resolve price set
            $providerPriceSetId = $lineArr[2];
            if(
                !empty($this->packageData[$providerPackageId]) 
                && !empty($this->hotelRoomData[$providerRoomId])
                && empty($this->priceSetsData[$providerPriceSetId])
                ) {
                $priceSetInputFields = ['id_at_provider' => $providerPriceSetId, 'package_id' => $this->packageData[$providerPackageId]['id']];
                $priceSetData = $this->priceSetService->getPriceSetData($priceSetOutputFields, $priceSetInputFields);
                if(!empty($priceSetData)) {
                    $this->priceSetsData[$providerPriceSetId] = $priceSetData['ps_id'];
                }
            }

            $departureDate = $lineArr[3];
            if(
                !empty($this->packageData[$providerPackageId])
                && !empty($this->hotelRoomData[$providerRoomId])
                && !empty($this->priceSetsData[$providerPriceSetId])
                && !empty($departureDates[$departureDate])
                ) {
                //get room info
                $mealPlanTitle = $lineArr[6];
                $mealPlanId = $this->mealPlanService->handleMealPlan($mealPlanTitle);

                if(!empty($mealPlanId)) {
                    $priceObj = $this->getNew();
                    $priceObj->setPackageId($this->packageData[$providerPackageId]['id']);
                    $priceObj->setHotelRoomCategoryId($this->hotelRoomData[$providerRoomId]);
                    $priceObj->setPriceSetId($this->priceSetsData[$providerPriceSetId]);
                    $priceObj->setDepartureDateId($departureDates[$departureDate]);
                    $priceObj->setGross($lineArr[4]);
                    $priceObj->setTax($lineArr[5]);
                    $priceObj->setMealPlanId($mealPlanId);
                    $priceObj->setInsertDate();

                    $this->insertIgnorePrice($priceObj);
                }
            } 
            //else {
            //    echo "No package data for package id ".$lineArr[0]."\n";
            //}
        }

        return true;
    }

    protected function insertIgnorePrice(\Entity\Price $priceObj)
    {
        $q = "INSERT IGNORE INTO ".PriceMetadata::$table." (";
        $q .= 'package_id, ';
        $q .= 'hotel_room_category_id, ';
        $q .= 'price_set_id, ';
        $q .= 'departure_date_id, '; 
        $q .= 'gross, ';
        $q .= 'tax, ';
        $q .= 'meal_plan_id, ';
        $q .= 'inserted_at';
        $q .= " ) VALUES (";

        $q .= "'".$priceObj->getPackageId()."', ";
        $q .= "'".$priceObj->getHotelRoomCategoryId()."', ";
        $q .= "'".$priceObj->getPriceSetId()."', ";
        $q .= "'".$priceObj->getDepartureDateId()."', ";
        $q .= "'".$priceObj->getGross()."', ";
        $q .= "'".$priceObj->getTax()."', ";
        $q .= "'".$priceObj->getMealPlanId()."', ";
        $q .= "'".$priceObj->getInsertedAt()."'";

        $q .= " )";

        $this->getDb()->executeQuery($q);
    }
}
