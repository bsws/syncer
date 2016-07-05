<?php
namespace Hydrator;

class HotelRoom
{
    public function getInstance()
    {
        return new HotelRoomGeneric();
    }
}
