<?php
namespace Service;

use Entity\Package as PackageEntity;
use Entity\PackageDepartureDate as PackageDepartureDateEntity;
use Hydrator\Package as PackageHydrator;
use Metadata\Package as PackageMetadata;
use Metadata\PackageDepartureDate as PackageDepartureDateMetadata;
use Comparer\Package as PackageComparer;

class Package extends Generic
{
    protected $hydrator;
    protected $hotelsMap = [];

    public function getHydrator()
    {
        if(empty($this->hydrator)) {
            $providerData = $this->getProviderData();
            $depService = $this->getSilexApplication()["service.departure_date"];
            $this->hydrator = PackageHydrator::getInstance($providerData, $depService, $this->getSilexApplication()['service.hotel']);
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
        $depService = $this->getSilexApplication()["service.departure_date"];
        //$depDateId = $depService->handleDepartureDate("2026-01-01");
        //die($depDateId);
        $providerData = $this->getProviderData();
        $providerEntity = $this->translateFromStdObject($packageConfig);
        $dbEntity = $this->getPackageFromDb($providerData['id'], $providerEntity->getIdAtProvider());

        //compare
        $packageDiff = PackageComparer::equalEntities($providerEntity, $dbEntity);
        if(true !== $packageDiff) {
            if(-1 === $packageDiff) {
                $this->insertPackage($providerEntity);
                $this->getLogger()->info("The package {$providerEntity->getId()}. - \"{$providerEntity->getName()}\" was inserted.");
                echo "The package {$providerEntity->getId()}. - \"{$providerEntity->getName()}\" was inserted.\r\n";
            } else {
                die("@TODO - To be imlemented(".__FILE__.", ".__LINE__.")");
            }
        }

    }

    public function sync($packagesData)
    {
        try {
        die("Solve this".__FILE__." - ".__LINE__);
            $hotelService = $this->getSilexApplication()['service.hotel'];
            $hotelService->buildHotelMap();
            $this->hotelsMap = $hotelService->getHotelsMap();
            ######################################
            echo '<div style="color:red;background-color:yellow;">'.__FILE__.':'.__LINE__.'</div>';
            echo '<pre>';
            print_r($this->hotelsMap);
            echo '</pre>';
            die;
            ######################################
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



    //insert package method
    protected function insertPackage(\Entity\Package $package)
    {
        $this->insertObject($package);

        //insert price sets
        $priceSets = $package->getPriceSets();
        if(!empty($priceSets)) {

            foreach($priceSets as $ps) {
                if(empty($ps->getPackageId())) {
                    $ps->setPackageId($package->getId());
                }

                $this->insertObject($ps);
                $this->getLogger()->info("The price set with id #{$ps->getId()}. - was inserted.");
                echo "The price set with id #{$ps->getId()}. - was inserted.\r\n";
            }
        }

        if(!empty($package->getDepartureDatesIds())) {
            $this->deleteDepartureDateIds($package);
            foreach($package->getDepartureDatesIds() as $departureDateId) {
                $depDateId = new PackageDepartureDateEntity();
                $depDateId->setPackageId($package->getId());
                $depDateId->setDepartureDateId($departureDateId);
                $this->insertObject($depDateId);
            }
        }
    }

    protected function deleteDepartureDateIds($Package)
    {
        if(!empty($Package->getId())) {
            return $this->getDb()->delete(PackageDepartureDateMetadata::$table, ["package_id" => $Package->getId()]);
        } 
        return null;
    }

    function getPackageData($outputFields, $inputFields) 
    {
        $fieldsToGet = "*";
        if(!empty($outputFields)) {
            $fieldAliases = PackageMetadata::dbColumnsAliases();
            $fieldsToGet = "";
            foreach($fieldAliases as $aliasKey => $aliasField) {
                foreach($outputFields as $f) {
                    if($aliasField == $f) {
                        $fieldsToGet .= $aliasKey." ".$aliasField.", ";
                    }
                }
            }
        }

        $conds = [];
        foreach($inputFields as $field => $val) {
            $conds[] = PackageMetadata::$tableAlias.".".$field." = '".$val."'";
        }

        $q = "
            SELECT
                ".rtrim($fieldsToGet, ", ")."
            FROM
                ".PackageMetadata::$table." ".PackageMetadata::$tableAlias."
            WHERE
                ".implode(" AND ", $conds)."
            ";

        try {
            $data = $this->getDb()->fetchAssoc($q);
        } catch(\Exception $Ex) {
            echo $Ex->getMessage();
            die;
            $data = [];
        }

        return $data;
    }

}
