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
}
