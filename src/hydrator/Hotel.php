<?php
namespace Hydrator;

class Hotel
{
    public function getInstance($providerId, $providerIdent)
    {
        switch($providerIdent) {
            case "christiantour":
                return new HotelChristiantour($providerId);
            break;
            default:
                throw new \Exception("There is not an Hotel Hydrator yet implemented for the provider ident -{$providerIdent}-");
            break;
        }
    }
}
