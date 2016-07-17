<?php

namespace Service;

class Generic
{
    protected $app = null;
    protected $dbal = null;
    protected $providerData = null;

    public function __construct($app)
    {
        $this->app = $app;
        $this->dbal = $app['db'];
    }

    public function getProviderData()
    {
        return $this->providerData;
    }

    public function getSilexApplication()
    {
        return $this->app;
    }

    public function getDb()
    {
        return $this->dbal;
    }

    public function setExtraParams($extraParams = [])
    {
        if(!empty($extraParams['providerData'])) {
            $this->providerData = $extraParams['providerData'];
        }
    }

    public function insertObject(\Entity\Generic $objToInsert)
    {
        try {
            $db = $this->getDb();
            $db->insert($objToInsert->getTableName(), $objToInsert->toArray());

            //if(strpos(get_class($objToInsert), "PackageDepartureDate")) {
            //    var_dump($objToInsert->disablePK);
            //    var_dump($objToInsert);
            //    die;
            //}
            if(empty($objToInsert->disablePK) || $objToInsert->disablePK !== true) {
                $lastInsertId = $db->lastInsertId();
                $objToInsert->setPkValue($lastInsertId);
                return $lastInsertId;
            } else {
                return null;
            }

        } catch(\Exception $Ex) {
            switch(get_class($Ex)) {
                case 'Doctrine\DBAL\DBALException':
                    echo "================";
                    echo $Ex->getMessage();
                    echo "================";
                break;
                default:
                    $this->getLogger()->info($Ex->getMessage());
                    echo $Ex->getMessage();
                break;
            }
        }

    }

    public function getLogger()
    {
        return $this->getSilexApplication()['logger'];
    }

    public function translateFromStdObjects(array $objsToTranslate, $providerId, $providerIdent)
    {
        $retArr = [];
        if(is_array($objsToTranslate) && count($objsToTranslate) > 0) 
        {
            foreach($objsToTranslate as $o) {
                $retArr[] = $this->translateFromStdObject($o, $providerId, $providerIdent);
            }
        }

        return $retArr;
    }
}
