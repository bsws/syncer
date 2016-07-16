<?php
namespace Hydrator;

class Departure
{
    public function getInstance()
    {
        return new DepartureGeneric();
    }
}
