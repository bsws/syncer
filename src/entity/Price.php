<?php

namespace Entity;

use Interfaces\GenericEntity as GenericEntityInterface;
use Entity\Generic as GenericEntity;
use Metadata\Price as PriceMetadata;

/**
 * Price
 */
class Price extends GenericEntity implements GenericEntityInterface
{
    protected $id;
    protected $packageId;
    protected $hotelRoomCategoryId;
    protected $priceSetId;
    protected $departureDateId;
    protected $gross;
    protected $tax;
    protected $mealPlanId;
    protected $insertedAt;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

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

    public function setHotelRoomCategoryId($hotelRoomCategoryId)
    {
        $this->hotelRoomCategoryId = $hotelRoomCategoryId;
        return $this;
    }

    public function getHotelRoomCategoryId()
    {
        return $this->hotelRoomCategoryId;
    }

    public function setPriceSetId($priceSetId)
    {
        $this->priceSetId = $priceSetId;
        return $this;
    }

    public function getPriceSetId()
    {
        return $this->priceSetId;
    }

    public function setDepartureDateId($departureDateId)
    {
        $this->departureDateId = $departureDateId;
        return $this;
    }

    public function getDepartureDateId()
    {
        return $this->departureDateId;
    }

    public function setGross($gross)
    {
        $this->gross = $gross;
        return $this;
    }

    public function getGross()
    {
        return $this->gross;
    }

    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

    public function getTax()
    {
        return $this->tax;
    }

    public function setMealPlanId($mealPlanId)
    {
        $this->mealPlanId = $mealPlanId;
        return $this;
    }

    public function getMealPlanId()
    {
        return $this->mealPlanId;
    }

    public function setInsertDate()
    {
        $this->insertedAt = date("Y-m-d H:i:s");
        return $this;
    }

    public function getInsertedAt()
    {
        return $this->insertedAt;
    }

    public function toArray($deep = false)
    {
        $retArr = [
            'id'  => $this->getId(), 
            'package_id' => $this->getPackageId(), 
            'hotel_room_category_id'    => $this->getHotelRoomCategoryId(), 
            'price_set_id' => $this->getPriceSetId(), 
            'departure_date_id'  => $this->getDepartureDateId(), 
            'gross'   => $this->getGross(), 
            'tax'    => $this->getTax(), 
            'meal_plan_id' => $this->getMealPlanId(),
            'inserted_at' => $this->getInsertedAt()
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
        return PriceMetadata::$table;
    }
}

