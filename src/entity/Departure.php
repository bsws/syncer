<?php
namespace Entity;

use Interfaces\GenericEntity;
use Metadata\Departure as DepartureMetadata;

class Departure extends Generic implements GenericEntity
{
	protected $id;
	protected $at;

	public function setId($id) 
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAt($at)
    {
        $this->at = $at;
        return $this;
    }

    public function getAt()
    {
        return $this->at;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'at' => $this->getAt()
        ];
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
        return DepartureMetadata::$table;
    }
}
