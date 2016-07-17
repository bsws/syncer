<?php
namespace Hydrator;

class DepartureDate
{
    public function getInstance()
    {
        return new DepartureDateGeneric();
    }
}
