<?php
namespace Hydrator;

class Price
{
    public function getInstance($providerId, $providerIdent, $depService = null)
    {
        switch($providerIdent) {
            case "christiantour":
                return new PriceChristiantour($providerId, $depService);
            break;
            default:
                throw new \Exception("There is not a Price Hydrator yet implemented for the provider ident -{$providerIdent}-");
            break;
        }
    }
}
