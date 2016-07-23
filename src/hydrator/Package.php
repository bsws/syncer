<?php
namespace Hydrator;

class Package 
{
    public function getInstance($providerData, $depService = null, $hotelService = null)
    {
        switch($providerData['ident']) {
            case "christiantour":
                return new PackageChristiantour($providerData, $depService, $hotelService);
            break;
            default:
                throw new \Exception("There is not a Package Hydrator yet implemented for the provider ident -{$providerIdent}-");
            break;
        }
    }
}
