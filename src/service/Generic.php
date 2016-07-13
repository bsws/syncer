<?php

namespace Service;

class Generic
{
    protected $app = null;
    protected $dbal = null;

    public function __construct($app)
    {
        $this->app = $app;
        $this->dbal = $app['db'];
    }

    public function getSilexApplication()
    {
        return $this->app;
    }

    public function getDb()
    {
        return $this->dbal;
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
}
