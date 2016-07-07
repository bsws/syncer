<?php
namespace Hydrator;

use Interfaces\Hydrators;
use Entity\Image as ImageEntity;

class ImageGeneric implements Hydrators
{
    public function hydrate($o/* source */) {
        //return new hotel room object

        //use a factory in the future
        $newObj = new ImageEntity();

        if(is_array($o)) {
            die("not implemented yet".__FILE__." - ".__LINE__);
            //if(!empty($o['dd_id'])) {
            //    $newObj->setId($o['dd_id']);
            //}

            //$newObj->setProviderId($o['dd_provider_id']);
            //$newObj->setHotelId($o['dd_hotel_id']);
            //$newObj->setLabel($o['dd_label']);
            //$newObj->setText($o['dd_text']);
            //$newObj->setIndex($o['dd_index']);
        } else {
            $newObj->setIdAtProvider($o->Id);
            $newObj->setMimeType($o->MimeType);
            $newObj->setName($o->Name);
        }

        return $newObj;
    }
}
