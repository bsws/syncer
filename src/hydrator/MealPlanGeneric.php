<?php
namespace Hydrator;

use Interfaces\Hydrators;
use Entity\MealPlan;

class MealPlanGeneric implements Hydrators
{
    public function hydrate($o/* source */) {
        //return new hotel room object

        //use a factory in the future
        $newObj = new MealPlan();

        if(is_array($o)) {
            if(!empty($o['mp_id'])) {
                $newObj->setId($o['mp_id']);
            }

            $newObj->setTitle($o['mp_title']);
        } else {
            $newObj->setTitle($o->Title);
        }

        return $newObj;
    }
}
