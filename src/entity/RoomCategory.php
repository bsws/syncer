<?php
namespace Entity;

use Interfaces\RoomCategoryable;
use Metadata\HotelRoom as HotelRoomMetadata;

class RoomCategory extends Generic implements RoomCategoryable
{
    protected $id;
    protected $providerId;
    protected $idAtProvider;
    protected $hotelId;
    protected $name;
    protected $description;
    protected $Images;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getProviderId()
    {
        return $this->providerId;
    }

    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
        return $this;
    }

    public function getIdAtProvider()
    {
        return $this->idAtProvider;
    }

    public function setIdAtProvider($idAtProvider)
    {
        $this->idAtProvider = $idAtProvider;
        return $this;
    }

    public function getHotelId()
    {
        return $this->hotelId;
    }

    public function setHotelId($hotelId)
    {
        $this->hotelId = $hotelId;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setImages($Images)
    {
        $this->Images = $Images;
        return $this;
    }

    public function getImages()
    {
        return $this->Images;
    }

    public function toArray($deep = false)
    {
        $retArr = [
            'id' => $this->getId(),
            // 'provider_id' => $this->getProviderId(),
            'id_at_provider' => $this->getIdAtProvider(),
            'hotel_id' => $this->getHotelId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
        ];

        if($deep) {
            $retArr['Images'] = [];
        }

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
        return HotelRoomMetadata::$table;
    }

    public function getIdentifier()
    {
        return $this->getProviderId()."_".$this->getIdAtProvider();
    }

    public function comparableFields()
    {
        return HotelRoomMetadata::comparableFields();
    }
}
