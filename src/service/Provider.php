<?php
namespace Service;

class Provider
{
    protected $dbal = null;
    public function __construct($app)
    {
        $this->dbal = $app['db'];
    }

    public function getProviderData($ident)
    {
        $q = "SELECT * FROM provider WHERE ident = '".$ident."'";
        return $this->dbal->fetchAssoc($q);
    }

    public function getProviderDataById($id)
    {
        $q = "SELECT * FROM provider WHERE id = '".$id."'";
        return $this->dbal->fetchAssoc($q);
    }
}
