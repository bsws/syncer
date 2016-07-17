<?php
namespace Service;

use Entity\DepartureDate as DepartureDateEntity;
use Hydrator\DepartureDate as DepartureDateHydrator;
use Metadata\DepartureDate as DepartureDateMetadata;

class DepartureDate extends Generic
{
    protected $hydrator;

    protected $departureDates = [];

    public function __construct($app)
    {
        parent::__construct($app);

        $this->departureDates = $this->getAll();
    }

    public function getHydrator()
    {
        if(empty($this->hydrator)) {
            $providerData = $this->getProviderData();
            $this->hydrator = DepartureDateHydrator::getInstance($providerData['id'], $providerData['ident']);
        }

        return $this->hydrator;
    }

    protected function getAll()
    {
        $q = "SELECT * FROM ".DepartureDateMetadata::$table." t ORDER BY at DESC";
        $dbArr = $this->getDb()->fetchAll($q);

        $retArr = [];

        foreach($dbArr as $entry) {
            $retArr[$entry["at"]] = $entry["id"];
        }

        return $retArr;
    }

    protected function addDepartureDateToCacheArr(\Entity\DepartureDate $depDate) 
    {
        if(!isset($this->departureDates[$depDate->getAt()])) {
            $this->departureDates[$depDate->getAt()] = $depDate->getId();
        }
    }

    //check for the date in the departure dates array.
    //if the date is there, return the id
    //otherwise, insert the new date in db / in the departureDates and then return the id
    public function handleDepartureDate($date)
    {
        if(!isset($this->departureDates[$date])) {
            $dateStd = (object) null;
            $dateStd->At = $date;

            $newObject = $this->getHydrator()->hydrate($dateStd);
            $this->insertObject($newObject);

            $this->addDepartureDateToCacheArr($newObject);

        }
        return $this->departureDates[$date];


    }

}
