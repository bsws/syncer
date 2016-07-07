<?php
namespace Entity;

use Interfaces\Imageable;

class Image implements Imageable
{

    protected $id;
    protected $providerId;
    protected $idAtProvider;
    protected $mimeType;
    protected $name;

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

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
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

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'provider_id' => $this->getProviderId(),
            'id_at_provider' => $this->getIdAtProvider(),
            'mime_type' => $this->getMimeType(),
            'name' => $this->getName()
        ];
    }
}
