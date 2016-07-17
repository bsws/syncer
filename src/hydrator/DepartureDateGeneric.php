<?php
namespace Hydrator;

use Interfaces\Hydrators;
use Entity\DepartureDate as DepartureDateEntity;

class DepartureDateGeneric implements Hydrators
{
    public function hydrate($o/* source */) {
        //return new hotel room object

        //use a factory in the future
        $newObj = new DepartureDateEntity();

        if(is_array($o)) {
            if(!empty($o['dep_id'])) {
                $newObj->setId($o['dep_id']);
            }

            $newObj->setAt($o['dep_at']);
        } else {
            //$newObj->setId($o->Id);
            $newObj->setAt($o->At);
        }

        return $newObj;
    }
}
