<?php
/**
* Geography service
*/
namespace Service;

use Entity\Geography as GeographyEntity;

class Geography extends Generic
{
    public function getNew()
    {
        $g = new GeographyEntity();
        return $g;
    }

    public function translateFromStdObject($o, $providerId)
    {
        $g = $this->getNew();

        //$g->setId($id);
        $g->setProviderId($providerId);
        $g->setIdAtProvider($o->Id);
        $g->setName($o->Name);
        $g->setIntName($o->IntName);
        $g->setChildLabel($o->ChildLabel);
        $g->setDescription($o->Description);
        $g->setImage($o->Image);


        //prepare the children objects
        if(is_array($o->Children) && count($o->Children) > 0) {
            $Children = [];
            foreach($o->Children as $oChild) {
                $Children[] = $this->translateFromStdObject($oChild, $providerId);
            }

            $g->setChildren($Children);
        }

        $g->setMinVal($o->MinVal);
        $g->setMaxVal($o->MaxVal);
        $g->setTreeLevel($o->TreeLevel);

        return $g;
    }

    public function getDbGeography($providerId, $parentId = null)
    {
        $q = "SELECT * FROM geography WHERE provider_id = ".$providerId;
        $dbData = $this->getDb()->fetchAssoc($q);

        return [];
    }

    public function insertGeography($objToInsert)
    {
        $arrData = [
            'provider_id' => $objToInsert->getProviderId(),
            'id_at_provider' => $objToInsert->getIdAtProvider(),
            'parent_id' => $objToInsert->getParentId() ? $objToInsert->getParentId() : 0,
            'name' => $objToInsert->getName(),
            'int_name' => $objToInsert->getIntName(),
            'child_label' => $objToInsert->getChildLabel(),
            'description' => $objToInsert->getDescription(),
            'min_val' => $objToInsert->getMinVal(),
            'max_val' => $objToInsert->getMaxVal(),
            'tree_level' => $objToInsert->getTreeLevel(),
        ];

        $this->getDb()->insert('geography', $arrData);
        $insertId = $this->getDb()->lastInsertId();

        $objToInsert->setId($insertId);

        if(is_array($objToInsert->getChildren()) && count($objToInsert->getChildren())) {
            $Children = $objToInsert->getChildren();
            foreach($Children as $child) {
                $child->setParentId($objToInsert->getId());
                $this->insertGeography($child);
            }
        }

        return true;
    }

    public function sync($geographyObject, $providerId)
    {
        //get db objects and hydrate them, resulting a big Entity\Geography Object
        $dbGeography = $this->getDbGeography($providerId);

        if(empty($dbGeography)) {
            //initial insert
            $this->insertGeography($geographyObject);
        }

        return true;

    }
}
