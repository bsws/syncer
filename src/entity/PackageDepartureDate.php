<?php
namespace Entity;

use Metadata\PackageDepartureDate as PackageDepartureDateMetadata;

class PackageDepartureDate extends Generic
{
    protected $packageId;
    protected $departureDateId;
    public $disablePK = true;

    public function setPackageId($packageId)
    {
        $this->packageId = $packageId;
        return $this;
    }

    public function setDepartureDateId($departureDateId)
    {
        $this->departureDateId = $departureDateId;
        return $this;
    }

    public function getPackageId()
    {
        return $this->packageId;
    }

    public function getDepartureDateId()
    {
        return $this->departureDateId;
    }

    public function toArray()
    {
        return [
            "package_id"    => $this->getPackageId(),
            "departure_date_id" => $this->getDepartureDateId()
        ];
    }

    public function getTableName()
    {
        return PackageDepartureDateMetadata::$table;
    }
}
