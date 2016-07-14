<?php
namespace Service;

use Entity\Package as PackageEntity;
use Hydrator\Package as PackageHydrator;
use Metadata\Package as PackageMetadata;
use Comparer\Package as PackageComparer;

class Package extends Generic
{
    protected $hydrator;

    public function getHydrator()
    {
        if(empty($this->hydrator)) {
            $providerData = $this->getProviderData();
            $this->hydrator = PackageHydrator::getInstance($providerData['id'], $providerData['ident']);
        }

        return $this->hydrator;
    }

    public function getNew()
    {
        $package = new PackageEntity();
        return $package;
    }

    public function translateFromStdObject($o)
    {
        $hydrator = $this->getHydrator();
        $newObj = $hydrator->hydrate($o);

        return $newObj;
    }

    protected function checkAndSync($packageConfig)
    {
        $providerData = $this->getProviderData();
        $providerEntity = $this->translateFromStdObject($packageConfig);
        $dbEntity = $this->getPackageFromDb($providerData['id'], $providerEntity->getIdAtProvider());

        //compare
        $packageDiff = PackageComparer::equalEntities($providerEntity, $dbEntity);

        if(true !== $packageDiff) {
            if(-1 === $packageDiff) {
                $this->insertObject($providerEntity);
                $this->getLogger()->info("The package {$providerEntity->getId()}. - \"{$providerEntity->getName()}\" was inserted.");
                echo "The package {$providerEntity->getId()}. - \"{$providerEntity->getName()}\" was inserted.\r\n";
            } else {
                die("@TODO - To be imlemented.");
            }
        }


    }

    public function sync($packagesData)
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

    protected function getPackageFromDb($providerId, $idAtProvider)
    {
        if(empty($providerId)) {
            throw new \Exception("No provider id specified for package object.");
        }

        if(empty($idAtProvider)) {
            throw new \Exception("No id at provider specified for package object.");
        }

        $q = $this->getSelectSql();
        $dbArr = $this->getDb()->fetchAll($q, ["provider_id" => $providerId, "id_at_provider" => $idAtProvider]);

        //hydrate
        $dbEntity = $this->getHydrator()->hydrate($dbArr);

        return $dbEntity;
    }

    public function getSelectSql()
    {
        $app = $this->getSilexApplication();
        $cols = PackageMetadata::dbColumnsAliases();

        $colsCount = count($cols);

        $count = 0;

        $q = "
            SELECT 
                ";
            foreach($cols as $k => $v) {
                $q .= " $k  $v";
                if($count < $colsCount - 1) {
                    $q .= ", ";
                }
                $q .= "\r\n";

                $count ++;
            }
        $q .= " 
            FROM 
                ".PackageMetadata::$table." p
            WHERE
                p.provider_id = :provider_id
                AND p.id_at_provider = :id_at_provider
        ";

        return $q;
    }

}
