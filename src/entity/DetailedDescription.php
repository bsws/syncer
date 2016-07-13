<?php
namespace Entity;

use Metadata\Description as DetailedDescriptionMetadata;

class DetailedDescription extends Generic
{
    protected $id;
    protected $providerId;
    protected $hotelId;
    protected $label;
    protected $text;
    protected $index;

    public function getIdentifier()
    {
        return $this->getHotelId()."_".$this->getLabel();
    }

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

    public function getHotelId()
    {
        return $this->hotelId;
    }

    public function setHotelId($hotelId)
    {
        $this->hotelId = $hotelId;
        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }

    public function toArray()
    {

        $retArr = [
            'provider_id' => $this->getProviderId(),
            'hotel_id' => $this->getHotelId(),
            'label' => $this->getLabel(),
            'text' => $this->getText(),
            'desc_index' => $this->getIndex()
        ];

        if(!empty($this->getId())) {
            $retArr['id'] = $this->getId();
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
        return DetailedDescriptionMetadata::$table;
    }
}
