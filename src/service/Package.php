<?php
namespace Service;

use Entity\Package as PackageEntity;
use Hydrator\Package as PackageHydrator;
use Metadata\Package as PackageMetadata;
use Comparer\Package as PackageComparer;

class Package extends Generic
{
    public function getNew()
    {
        $package = new PackageEntity();
        return $package;
    }

    public function translateFromStdObject($o, $providerId, $providerIdent)
    {
        $hydrator = PackageHydrator::getInstance($providerId, $providerIdent);
        $newObj = $hydrator->hydrate($o);
        return $newObj;
    }

    protected function checkAndSync($packageConfig)
    {
    }

    public function sync($packagesData, $providerId, $providerIdent)
    {
        try {
            foreach($packagesData as $data) {
                $this->checkAndSync($data);
            }
        } catch(\Exception $Ex) {
            echo $Ex->getMessage();
            die();
        }
    }

}
