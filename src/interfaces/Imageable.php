<?php
namespace Interfaces;

interface Imageable
{
    public function setId($id);
    public function getId();

    public function setProviderId($providerId);
    public function getProviderId();

    public function setIdAtProvider($idAtProvider);
    public function getIdAtProvider();

    public function setMimeType($mimeType);
    public function getMimeType();

    public function setName($name);
    public function getName();
}
