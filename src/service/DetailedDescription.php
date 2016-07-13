<?php
namespace Service;

class DetailedDescription extends Generic
{
    public function insertDescription($description)
    {
        echo "To insert detailed description.\r\n";
        $this->insertObject($description);
        $this->getLogger()->info("The description with pk {$description->getPkValue()} was inserted.");
        return $description->getPkValue();
    }
}
