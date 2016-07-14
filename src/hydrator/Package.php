<?php
namespace Hydrator;

class Package 
{
    public function getInstance($providerId, $providerIdent)
    {
        switch($providerIdent) {
            case "christiantour":
                return new PackageChristiantour($providerId);
            break;
            default:
                throw new \Exception("There is not a Package Hydrator yet implemented for the provider ident -{$providerIdent}-");
            break;
        }
    }
}
