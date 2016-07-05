<?php
namespace Hydrator;

use Interfaces\Hydrators;
use Entity\DetailedDescription as HotelDetailedDescription;

class DetailedDescriptionGeneric implements Hydrators
{
    public function hydrate($o/* source */) {
        //return new hotel room object

        //use a factory in the future
        $newObj = new HotelDetailedDescription();

        if(is_array($o)) {
            if(!empty($o['dd_id'])) {
                $newObj->setId($o['dd_id']);
            }

            $newObj->setProviderId($o['dd_provider_id']);
            $newObj->setHotelId($o['dd_hotel_id']);
            $newObj->setLabel($o['dd_label']);
            $newObj->setText($o['dd_text']);
            $newObj->setIndex($o['dd_index']);
        } else {
            //$newObj->setProviderId($o['dd_provider_id']);
            //$newObj->setHotelId($o['dd_hotel_id']);
            $newObj->setLabel($o->label);
            $newObj->setText($o->text);
            $newObj->setIndex($o->index);
        }

        return $newObj;
    }
}
