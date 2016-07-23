<?php
namespace Service;

use Entity\Price as PriceEntity;

class Price extends Generic
{
    protected $hydrator;

    public function getHydrator()
    {
        if(empty($this->hydrator)) {
            $providerData = $this->getProviderData();
            $depService = $this->getSilexApplication()["service.departure_date"];
            $this->hydrator = PackageHydrator::getInstance($providerData['id'], $providerData['ident'], $depService);
        }

        return $this->hydrator;
    }

    public function getNew()
    {
        $package = new PriceEntity();
        return $package;
    }

    public function sync($pricesArr) 
    {
        $providerData = $this->getProviderData();
    }
}
