<?php
namespace Interfaces;

interface RoomCategoryable
{
    public function setId($id);
    public function getId();

    public function setProviderId($providerId);
    public function getProviderId();

    public function setIdAtProvider($idAtProvider);
    public function getIdAtProvider();

    public function setName($name);
    public function getName();

    public function setDescription($description);
    public function getDescription();

    public function setImages($Images);
    public function getImages();
}
