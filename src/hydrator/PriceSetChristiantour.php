<?php
namespace Hydrator;

use Interfaces\Hydrators;
use Entity\PriceSet as PriceSetEntity;

class PriceSetChristiantour implements Hydrators
{
    public function hydrate($o/* source */) {
        //return new hotel room object

        //use a factory in the future
        $newObj = new PriceSet();

        if(is_array($o)) {
            if(!empty($o['ps_id'])) {
                $newObj->setId($o['ps_id']);
            }

            $newObj->setIdAtProvider($o['ps_id_at_provider']);
            $newObj->setPackageId($o['ps_package_id']);
            $newObj->setLabel($o['ps_label']);
            $newObj->setDescription($o['ps_description']);
            $newObj->setValidFrom($o['ps_valid_from']);
            $newObj->setValidTo($o['ps_valid_to']);
            $newObj->setTravelFrom($o['ps_travel_from']);
            $newObj->setTravelTo($o['ps_travel_to']);
        } else {
            $newObj->setIdAtProvider($o->Id);
            //$newObj->setPackageId($o['ps_package_id']);
            $newObj->setLabel($o->Label);
            $newObj->setDescription($o->Description);
            $newObj->setValidFrom($o->ValidFrom);
            $newObj->setValidTo($o->ValidTo);
            $newObj->setTravelFrom($o->TravelFrom);
            $newObj->setTravelTo($o->TravelTo);
        }

        return $newObj;
    }
}
