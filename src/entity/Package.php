<?php

namespace Entity;

use Interfaces\Packageable;
use Entity\Generic as GenericEntity;
use Metadata\Package as PackageMetadata;
/**
 * Package
 */
class Package extends GenericEntity implements Packageable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $providerId;

    /**
     * @var int
     */
    private $idAtProvider;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $isTour;

    /**
     * @var bool
     */
    private $isBus;

    /**
     * @var bool
     */
    private $isFlight;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var int
     */
    private $outboundTransportDuration;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $destinationId;

    /**
     * @var string
     */
    private $includedServices;

    /**
     * @var string
     */
    private $notIncludedServices;

    /**
     * @var int
     */
    private $hotelId;

    /**
     * @var int
     */
    private $hotelSourceId;

    /**
     * @var int
     */
    private $currencyId;

    private $DepartureDates;

    private $DeparturePoints;

    private $PriceSets;

    private $DetailedDescriptions;

    private $TalePrice;

    public function __construct()
    {
        $this->DepartureDates = [];
        $this->DeparturePoints = [];
        $this->PriceSets = [];
        $this->DetailedDescriptions = [];
        $this->TalePrice = [];
    }


    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set providerId
     *
     * @param integer $providerId
     *
     * @return Package
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;

        return $this;
    }

    /**
     * Get providerId
     *
     * @return int
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * Set idAtProvider
     *
     * @param integer $idAtProvider
     *
     * @return Package
     */
    public function setIdAtProvider($idAtProvider)
    {
        $this->idAtProvider = $idAtProvider;

        return $this;
    }

    /**
     * Get idAtProvider
     *
     * @return int
     */
    public function getIdAtProvider()
    {
        return $this->idAtProvider;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Package
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isTour
     *
     * @param boolean $isTour
     *
     * @return Package
     */
    public function setIsTour($isTour)
    {
        $this->isTour = $isTour;

        return $this;
    }

    /**
     * Get isTour
     *
     * @return bool
     */
    public function getIsTour()
    {
        return $this->isTour;
    }

    /**
     * Set isBus
     *
     * @param boolean $isBus
     *
     * @return Package
     */
    public function setIsBus($isBus)
    {
        $this->isBus = $isBus;

        return $this;
    }

    /**
     * Get isBus
     *
     * @return bool
     */
    public function getIsBus()
    {
        return $this->isBus;
    }

    /**
     * Set isFlight
     *
     * @param boolean $isFlight
     *
     * @return Package
     */
    public function setIsFlight($isFlight)
    {
        $this->isFlight = $isFlight;

        return $this;
    }

    /**
     * Get isFlight
     *
     * @return bool
     */
    public function getIsFlight()
    {
        return $this->isFlight;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Package
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set outboundTransportDuration
     *
     * @param integer $outboundTransportDuration
     *
     * @return Package
     */
    public function setOutboundTransportDuration($outboundTransportDuration)
    {
        $this->outboundTransportDuration = $outboundTransportDuration;

        return $this;
    }

    /**
     * Get outboundTransportDuration
     *
     * @return int
     */
    public function getOutboundTransportDuration()
    {
        return $this->outboundTransportDuration;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Package
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set destinationId
     *
     * @param integer $destinationId
     *
     * @return Package
     */
    public function setDestinationId($destinationId)
    {
        $this->destinationId = $destinationId;

        return $this;
    }

    /**
     * Get destinationId
     *
     * @return int
     */
    public function getDestinationId()
    {
        return $this->destinationId;
    }

    /**
     * Set includedServices
     *
     * @param string $includedServices
     *
     * @return Package
     */
    public function setIncludedServices($includedServices)
    {
        $this->includedServices = $includedServices;

        return $this;
    }

    /**
     * Get includedServices
     *
     * @return string
     */
    public function getIncludedServices()
    {
        return $this->includedServices;
    }

    /**
     * Set notIncludedServices
     *
     * @param string $notIncludedServices
     *
     * @return Package
     */
    public function setNotIncludedServices($notIncludedServices)
    {
        $this->notIncludedServices = $notIncludedServices;

        return $this;
    }

    /**
     * Get notIncludedServices
     *
     * @return string
     */
    public function getNotIncludedServices()
    {
        return $this->notIncludedServices;
    }

    /**
     * Set hotelId
     *
     * @param integer $hotelId
     *
     * @return Package
     */
    public function setHotelId($hotelId)
    {
        $this->hotelId = $hotelId;

        return $this;
    }

    /**
     * Get hotelId
     *
     * @return int
     */
    public function getHotelId()
    {
        return $this->hotelId;
    }

    /**
     * Set hotelSourceId
     *
     * @param integer $hotelSourceId
     *
     * @return Package
     */
    public function setHotelSourceId($hotelSourceId)
    {
        $this->hotelSourceId = $hotelSourceId;

        return $this;
    }

    /**
     * Get hotelSourceId
     *
     * @return int
     */
    public function getHotelSourceId()
    {
        return $this->hotelSourceId;
    }

    /**
     * Set currencyId
     *
     * @param integer $currencyId
     *
     * @return Package
     */
    public function setCurrencyId($currencyId)
    {
        $this->currencyId = $currencyId;

        return $this;
    }

    /**
     * Get currencyId
     *
     * @return int
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    public function setDepartureDates($DepartureDates) 
    {
        $this->DepartureDates = $DepartureDates;
        return $this;
    }

    public function getDepartureDates() 
    {
        return $this->DepartureDates;
    }

    public function setDeparturePoints($DeparturePoints) 
    {
        $this->DeparturePoints = $DeparturePoints;
        return $this;
    }

    public function getDeparturePoints() 
    {
        return $this->DeparturePoints;
    }

    public function setPriceSets($PriceSets) 
    {
        $this->PriceSets = $PriceSets;
        return $this;
    }

    public function getPriceSets() 
    {
        return $this->PriceSets;
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

    public function setTalePrice($TalePrice) 
    {
        $this->TalePrice = $TalePrice;
        return $this;
    }

    public function getTalePrice() 
    {
        return $this->TalePrice;
    }

    public function toArray($deep = false)
    {
        $retArr = [
            'id'  => $this->getId(), 
            'provider_id' => $this->getProviderId(), 
            'id_at_provider'  => $this->getIdAtProvider(), 
            'name'    => $this->getName(), 
            'is_tour' => $this->getIsTour(), 
            'is_bus'  => $this->getIsBus(), 
            'is_flight'   => $this->getIsFlight(), 
            'duration'    => $this->getDuration(), 
            'outbound_transport_duration' => $this->getOutboundTransportDuration(), 
            'description' => $this->getDescription(),
            'destination_id'  => $this->getDestinationId(), 
            'included_services'   => $this->getIncludedServices(), 
            'not_included_services'   => $this->getNotIncludedServices(), 
            'hotel_id'    => $this->getHotelId(), 
            'hotel_source_id' => $this->getHotelSourceId() 
        ];

        if($deep) {
            //to implement this later
            $retArr['DepartureDates'] = [];
            $retArr['DeparturePoints'] = [];
            $retArr['PriceSets'] = [];
            $retArr['DetailedDescriptions'] = [];
            $retArr['TalePrice'] = [];
        }

        return $retArr;
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
        return PackageMetadata::$table;
    }
}

