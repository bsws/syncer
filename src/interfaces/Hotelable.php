<?php
namespace Interfaces;

interface Hotelable
{
    public function getPkValue();

    public function getId();
    public function setId($id);

    public function getProviderId();
    public function setProviderId($providerId);

    public function getIdAtProvider();
    public function setIdAtProvider($idAtProvider);

	public function getSource();
	public function setSource($source);

	public function getSourceId();
	public function setSourceId($sourceId);
	
    public function getCode();
    public function setCode($code);
	
    public function getName();
    public function setName($name);
	
    public function getStars();
    public function setStars($stars);
	
    public function getDescription();
    public function setDescription($description);
	
    public function getAddress();
    public function setAddress($address);
	
    public function getZip();
    public function setZip($zip);
	
    public function getPhone();
    public function setPhone($phone);
	
    public function getFax();
    public function setFax($fax);
	
    public function getLocation();
    public function setLocation($location);
	
    public function getUrl();
    public function setUrl($url);
	
    public function getLatitude();
    public function setLatitude($latitude);
	
    public function getLongitude();
    public function setLongitude($longitude);
	
    public function getRoomCategories();
    public function setRoomCategories($RoomCategories);
	
    public function getImages();
    public function setImages($Images);
	
    public function getDetailedDescriptions();
    public function setDetailedDescriptions($DetailedDescriptions);
	
    public function getHotelTheme();
    public function setHotelTheme($HotelTheme);
	
    public function getHotelAmenities();
    public function setHotelAmenities($HotelAmenities);

	public function getRoomAmenities();
	public function setRoomAmenities($RoomAmenities);

	public function getExtraClass();
	public function setExtraClass($extraClass);
	
    public function getUseIndividually();
    public function setUseIndividually($useIndividually);
	
    public function getUseOnPackages();
    public function setUseOnPackages($useOnPackages);

	public function getPropertyType();
	public function setPropertyType($propertyType);
}
