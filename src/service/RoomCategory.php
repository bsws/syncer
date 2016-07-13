<?php
namespace Service;

class RoomCategory extends Generic
{
    public function insertRoomCategory($roomCategory) {
        echo "To insert room category.\r\n";
        $this->insertObject($roomCategory);
        $this->getLogger()->info("The Room with pk {$roomCategory->getPkValue()} was inserted.");
        return $roomCategory->getPkValue();
    }
}
