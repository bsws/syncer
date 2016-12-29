<?php
namespace Entity;

use Metadata\PackageDeparturePoint as PackageDeparturePointMetadata;

class PackageDeparturePoint extends Generic
{
    protected $packageId;
    protected $departurePointId;
    public $disablePK = true;

    public function setPackageId($packageId)
    {
        $this->packageId = $packageId;
        return $this;
    }

    public function setDeparturePointId($departurePointId)
    {
        $this->departurePointId = $departurePointId;
        return $this;
    }

    public function getPackageId()
    {
        return $this->packageId;
    }

    public function getDeparturePointId()
    {
        return $this->departurePointId;
    }

    public function toArray()
    {
        return [
            "package_id"    => $this->getPackageId(),
            "departure_point_id" => $this->getDeparturePointId()
        ];
    }

    public function getTableName()
    {
        return PackageDeparturePointMetadata::$table;
    }
}
