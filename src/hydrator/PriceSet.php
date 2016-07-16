<?php
namespace Hydrator;

class PriceSet
{
    public function getInstance($providerId, $providerIdent)
    {
        switch($providerIdent) {
            case "christiantour":
                return new PriceSetChristiantour($providerId);
            break;
            default:
                throw new \Exception("There is not a PriceSet Hydrator yet implemented for the provider ident -{$providerIdent}-");
            break;
        }
    }
}
