<?php

namespace Entity;

use Interfaces\Geographyable;

class Geography extends Generic implements Geographyable
{

    protected $id;
    protected $providerId;
    protected $idAtProvider;
    protected $parentId;
    protected $name;
    protected $intName;
    protected $childLabel;
    protected $description;
    protected $Image;
    protected $Children;
    protected $minVal;
    protected $maxVal;
    protected $treeLevel;

    public function setId($id) 
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
        return $this;
    }

    public function getProviderId()
    {
        return $this->providerId;
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

    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function getParentId()
    {
        return $this->parentId;
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

    public function setIntName($intName)
    {
        $this->intName = $intName;
        return $this;
    }

    public function getIntName()
    {
        return $this->intName;
    }

    public function setChildLabel($childLabel)
    {
        $this->childLabel = $childLabel;
        return $this;
    }

    public function getChildLabel()
    {
        return $this->childLabel;
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

    public function setImage($Image)
    {
        $this->Image = $Image;
        return $this;
    }

    public function getImage()
    {
        return $this->Image;
    }

    public function setChildren(array $Children = [])
    {
        $this->Children = $Children;
        return $this;
    }

    public function getChildren()
    {
        return $this->Children;
    }

    public function setMinVal($minVal)
    {
        $this->minVal = (float) $minVal;
        return $this;
    }

    public function getMinVal()
    {
        return $this->minVal;
    }

    public function setMaxVal($maxVal)
    {
        $this->maxVal = (float) $maxVal;
        return $this;
    }

    public function getMaxVal()
    {
        return $this->maxVal;
    }

    public function setTreeLevel($treeLevel)
    {
        $this->treeLevel = $treeLevel;
        return $this;
    }

    public function getTreeLevel()
    {
        return $this->treeLevel;
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
        
    }
}
