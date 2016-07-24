<?php
namespace Service;

use Entity\MealPlan as MealPlanEntity;
use Hydrator\MealPlan as MealPlanHydrator;
use Metadata\MealPlan as MealPlanMetadata;

class MealPlan extends Generic
{
    protected $mealPlans = [];

    public function __construct($app)
    {
        parent::__construct($app);

        $this->mealPlans = $this->getAll();
    }

    public function getHydrator()
    {
        if(empty($this->hydrator)) {
            $providerData = $this->getProviderData();
            $this->hydrator = MealPlanHydrator::getInstance($providerData['id'], $providerData['ident']);
        }

        return $this->hydrator;
    }

    public function getAll()
    {
        $q = "SELECT * FROM ".MealPlanMetadata::$table." t ORDER BY title DESC";
        $dbArr = $this->getDb()->fetchAll($q);

        $retArr = [];

        foreach($dbArr as $entry) {
            $retArr[strtolower($entry["title"])] = $entry["id"];
        }

        return $retArr;
    }

    protected function addMealPlanToCacheArr(\Entity\MealPlan $mealPlan) 
    {
        if(!isset($this->mealPlans[strtolower($mealPlan->getTitle())])) {
            $this->mealPlans[strtolower($mealPlan->getTitle())] = $mealPlan->getId();
        }
    }

    public function handleMealPlan($title)
    {
        if(!isset($this->mealPlans[strtolower($title)])) {
            $mealStd = (object) null;
            $mealStd->Title = $title;

            $newObject = $this->getHydrator()->hydrate($mealStd);
            $this->insertObject($newObject);

            $this->addMealPlanToCacheArr($newObject);

        }
        return $this->mealPlans[strtolower($title)];


    }
}
