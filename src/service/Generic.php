<?php

namespace Service;

class Generic
{
    protected $dbal = null;

    public function __construct($app)
    {
        $this->dbal = $app['db'];
    }

    public function getDb()
    {
        return $this->dbal;
    }
}
