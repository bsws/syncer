<?php
namespace Entity;

use Interfaces\GenericEntity;
use Metadata\MealPlan as MealPlanMetadata;

class MealPlan extends Generic implements GenericEntity
{
	protected $id;
	protected $title;

	public function setId($id) 
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle()
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
        return MealPlanMetadata::$table;
    }
}
