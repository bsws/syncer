<?php
namespace Service;

use Metadata\HotelRoom as HotelRoomMetadata;

class RoomCategory extends Generic
{
    public function insertRoomCategory($roomCategory) {
        //echo "To insert room category.\r\n";
        $this->insertObject($roomCategory);
        $this->getLogger()->info("The Room with pk {$roomCategory->getPkValue()} was inserted.");
        return $roomCategory->getPkValue();
    }

    function getHotelRoomData($outputFields, $inputFields) 
    {
        $fieldsToGet = "*";
        if(!empty($outputFields)) {
            $fieldAliases = HotelRoomMetadata::dbColumnsAliases();
            $fieldsToGet = "";
            foreach($fieldAliases as $aliasKey => $aliasField) {
                foreach($outputFields as $f) {
                    if($aliasField == $f) {
                        $fieldsToGet .= $aliasKey." ".$aliasField.", ";
                    }
                }
            }
        }

        $conds = [];
        foreach($inputFields as $field => $val) {
            $conds[] = HotelRoomMetadata::$tableAlias.".".$field." = '".$val."'";
        }

        $q = "
            SELECT
                ".rtrim($fieldsToGet, ", ")."
            FROM
                ".HotelRoomMetadata::$table." ".HotelRoomMetadata::$tableAlias."
            WHERE
                ".implode(" AND ", $conds)."
            ";

        try {
            $data = $this->getDb()->fetchAssoc($q);
        } catch(\Exception $Ex) {
            echo $Ex->getMessage();
            die;
            $data = [];
        }

        return $data;
    }

}
