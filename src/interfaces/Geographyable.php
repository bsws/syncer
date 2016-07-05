<?php

namespace Interfaces;

Interface Geographyable
{
    public function setId($id);
    public function getId();

    public function setProviderId($providerId);
    public function getProviderId();

    public function setIdAtProvider($idAtProvider);
    public function getIdAtProvider();

    public function setName($name);
    public function getName();

    public function setIntName($intName);
    public function getIntName();

    public function setChildLabel($childLabel);
    public function getChildLabel();

    public function setDescription($description);
    public function getDescription();

    public function setImage($Image);
    public function getImage();

    public function setChildren(array $Children = []);
    public function getChildren();

    public function setMinVal($minVal);
    public function getMinVal();

    public function setMaxVal($maxVal);
    public function getMaxVal();

    public function setTreeLevel($treeLevel);
    public function getTreeLevel();
}
