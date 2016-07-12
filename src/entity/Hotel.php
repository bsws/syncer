<?php

namespace Entity;

use Interfaces\Hotelable;
use Entity\Generic as GenericModel;

class Hotel extends GenericModel implements Hotelable
{
	protected $id;
	protected $providerId;
	protected $idAtProvider;
	protected $source;
	protected $sourceId;
	protected $code;
	protected $name;
	protected $stars;
	protected $description;
	protected $address;
	protected $zip;
	protected $phone;
	protected $fax;
	protected $location;
	protected $url;
	protected $latitude;
	protected $longitude;
	protected $RoomCategories;
	protected $Images;
	protected $DetailedDescriptions;
	protected $HotelTheme;
	protected $HotelAmenities;
	protected $RoomAmenities;
	protected $extraClass;
	protected $useIndividually;
	protected $useOnPackages;
	protected $propertyType;

    public function __construct()
    {
        $this->RoomCategories = [];
        $this->Images = [];
        $this->DetailedDescriptions = [];
        $this->HotelAmenities = [];
        $this->RoomAmenities = [];
    }

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

	public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }
		
	public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;
        return $this;
    }

    public function getSourceId()
    {
        return $this->sourceId;
    }
		
	public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
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
		
	public function setStars($stars)
    {
        $this->stars = $stars;
        return $this;
    }

    public function getStars()
    {
        return $this->stars;
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
		
	public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }
		
	public function setZip($zip)
    {

        $this->zip = $zip;
        return $this;
    }

    public function getZip()
    {
        return $this->zip;
    }
		
	public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }
		
	public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    public function getFax()
    {
        return $this->fax;
    }
		
	public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }
		
	public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }
		
	public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }
		
	public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
		
	public function setRoomCategories($RoomCategories)
    {
        $this->RoomCategories = $RoomCategories;
        return $this;
    }

    public function getRoomCategories()
    {
        return $this->RoomCategories;
    }
		
	public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    public function getImages()
    {
        return $this->images;
    }
		
	public function setDetailedDescriptions($DetailedDescriptions)
    {
        $this->DetailedDescriptions = $DetailedDescriptions;
        return $this;
    }

    public function getDetailedDescriptions()
    {
        return $this->DetailedDescriptions;
    }
		
	public function setHotelTheme($HotelTheme)
    {
        $this->HotelTheme = $HotelTheme;
        return $this;
    }

    public function getHotelTheme()
    {
        return $this->HotelTheme;
    }
		
	public function setHotelAmenities($HotelAmenities)
    {
        $this->HotelAmenities = $HotelAmenities;
        return $this;
    }

    public function getHotelAmenities()
    {
        return $this->HotelAmenities;
    }
		
	public function setRoomAmenities($RoomAmenities)
    {
        $this->RoomAmenities = $RoomAmenities;
        return $this;
    }

    public function getRoomAmenities()
    {
        return $this->RoomAmenities;
    }
		
	public function setExtraClass($extraClass)
    {
        $this->extraClass = $extraClass;
        return $this;
    }

    public function getExtraClass()
    {
        return $this->extraClass;
    }
		
	public function setUseIndividually($useIndividually)
    {
        $this->useIndividually = $useIndividually;
        return $this;
    }

    public function getUseIndividually()
    {
        return $this->useIndividually;
    }
		
	public function setUseOnPackages($useOnPackages)
    {
        $this->useOnPackages = $useOnPackages;
        return $this;
    }

    public function getUseOnPackages()
    {
        return $this->useOnPackages;
    }
		
	public function setPropertyType($PropertyType)
    {
        $this->propertyType = $PropertyType;
        return $this;
    }

    public function getPropertyType()
    {
        return $this->propertyType;
    }

    public function addRoomCategory(\Entity\RoomCategory $roomCategory)
    {
        $this->RoomCategories[] = $roomCategory;
    }

    public function addImage(\Entity\Image $image)
    {
        $this->Images[] = $image;
    }

    public function addDetailedDescription(\Entity\DetailedDescription $detailedDescription)
    {
        $this->DetailedDescriptions[] = $detailedDescription;
    }

    public function toArray($deep = false)
    {
        $retArr = [
            'id' => $this->getId(),
            'provider_id' => $this->getProviderId(),
            'id_at_provider' => $this->getIdAtProvider(),
            'source' => $this->getSource(),
            'source_id' => $this->getSourceId(),
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'stars' => $this->getStars(),
            'description' => $this->getDescription(),
            'address' => $this->getAddress(),
            'zip' => $this->getZip(),
            'phone' => $this->getPhone(),
            'fax' => $this->getFax(),
            'location' => $this->getLocation(),
            'url' => $this->getUrl(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'extra_class' => $this->getExtraClass(),
            'use_individually' => $this->getUseIndividually(),
            'use_on_packages' => $this->getUseOnPackages(),
            'property_type' => $this->getPropertyType(),
        ];

        if($deep) {
            $retArr['RoomCategories'] = array_map(
                function($roomCategory) { 
                    return $roomCategory->toArray(); 
                    }, 
                    $this->getRoomCategories()
                );
            $retArr['Images'] = array_map(
                function($image) { 
                    return $image->toArray(); 
                    }, 
                    $this->getImages()
                );
            $retArr['DetailedDescriptions'] = array_map(
                function($detailedDescription) { 
                    return $detailedDescription->toArray(); 
                    }, 
                    $this->getDetailedDescriptions()
                );
            $retArr['HotelAmenities'] = [];
            $retArr['RoomAmenities'] = [];
            $retArr['HotelTheme'] = [];
        }

        //room categories

        return $retArr;
    }

    public function getPkValue()
    {
        return $this->getId();
    }
}
