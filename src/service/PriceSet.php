<?php
namespace Service;

use Metadata\PriceSet as PriceSetMetadata;

class PriceSet extends Generic
{
    function getPriceSetData($outputFields, $inputFields) 
    {
        $fieldsToGet = "*";
        if(!empty($outputFields)) {
            $fieldAliases = PriceSetMetadata::dbColumnsAliases();
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
            $conds[] = PriceSetMetadata::$tableAlias.".".$field." = '".$val."'";
        }

        $q = "
            SELECT
                ".rtrim($fieldsToGet, ", ")."
            FROM
                ".PriceSetMetadata::$table." ".PriceSetMetadata::$tableAlias."
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
