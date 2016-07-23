<?php

namespace Entity;

use Interfaces\GenericEntity as GenericEntityInterface;
use Entity\Generic as GenericEntity;
use Metadata\PriceSet as PriceSetMetadata;

/**
 * Price
 */
class PriceSet extends GenericEntity implements GenericEntityInterface
{
    private $id;
    private $packageId;
    private $hotelRoomCategoryId;
    private $priceSetId;
    private $departureDateId;
    private $gross;
    private $tax;
    private $mealTypeId;
    private $insertedAt;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setIdAtProvider($idAtProvider)
    {
        $this->idAtProvider = $idAtProvider;

        return $this;
    }

    public function getIdAtProvider()
    {
        return $this->idAtProvider;
    }

    public function setPackageId($packageId)
    {
        $this->packageId = $packageId;
        return $this;
    }

    public function getPackageId()
    {
        return $this->packageId;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setValidFrom($str)
    {
        $this->validFrom = $str;
        return $this;
    }

    public function getValidFrom()
    {
        return $this->validFrom;
    }

    public function setValidTo($str)
    {
        $this->validTo = $str;
        return $this;
    }

    public function getValidTo()
    {
        return $this->validTo;
    }

    public function setTravelFrom($str)
    {
        $this->travelFrom = $str;
        return $this;
    }

    public function getTravelFrom()
    {
        return $this->travelFrom;
    }

    public function setTravelTo($str)
    {
        $this->travelTo = $str;
        return $this;
    }

    public function getTravelTo()
    {
        return $this->travelTo;
    }

    public function toArray($deep = false)
    {
        $retArr = [
            'id'  => $this->getId(), 
            'id_at_provider'  => $this->getIdAtProvider(), 
            'package_id'    => $this->getPackageId(), 
            'label'    => $this->getLabel(), 
            'description'    => $this->getDescription(), 
            'valid_from' => $this->getValidFrom(), 
            'valid_to'  => $this->getValidTo(), 
            'travel_from'   => $this->getTravelFrom(), 
            'travel_to'    => $this->getTravelTo(), 
        ];

        return $retArr;
    }

    public function getPkValue()
    {
        return $this->getId();
    }

    public function setPkValue($val)
    {
        $this->setId($val);
        return $this;
    }

    public function getTableName()
    {
        return PriceSetMetadata::$table;
    }
}

