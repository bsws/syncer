<?php
namespace Entity;

class Amenity
{
	protected $id;
	protected $name;
	protected $objectType;
	
	public function setId($id) 
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }	
	
	public function setName($name) 
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

	public function setObjectType($objectType) 
    {
        $this->objectType = $objectType;
        return $this;
    }

    public function getObjectType()
    {
        return $this->objectType;
    }
}
