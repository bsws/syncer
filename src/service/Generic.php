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
            $lastInsertId = $db->lastInsertId();
            $objToInsert->setPkValue($lastInsertId);

            return $lastInsertId;
        } catch(\Exception $Ex) {
            $this->getLogger()->info($Ex->getMessage());
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
