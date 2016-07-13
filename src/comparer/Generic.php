<?php
namespace Comparer;

use Util\String as StringUtils;

class Generic 
{
    /**
    * @param \Entity\Generic $providerInstance the data that came from provider
    * @param \Entity\Generic $dbInstance the data that came from db
    *
    * @return -1 | true | $unequalFields array
    * -1 when the object must be inserted
    * true when the object are equals
    * $unequalFields when there are fields that must be updated.
    **/
    public static function equalEntities(\Entity\Generic $providerInstance, \Entity\Generic $dbInstance) {
        if(empty($dbInstance->getPkValue())) {
            return -1;
        }

        $comparableFields = static::comparableFields();
        $unequalFields = [];
        foreach ($comparableFields as $fieldName) {
            $methodName = self::buildMethodName($fieldName);
            $providerVal = call_user_method($methodName, $providerInstance);
            $dbVal = call_user_method($methodName, $dbInstance);


            if($providerVal != $dbVal) {
                //echo $methodName,"|", $providerVal, "|", $dbVal ,"\r\n";
                $unequalFields[$fieldName] = $providerVal;
            }
        }

        return empty($unequalFields) ? true : $unequalFields;
    }

    public static function buildMethodName($ident, $prefix = "get")
    {
        return $prefix.StringUtils::dashToCamelcase($ident, true);
    }

    public static function compareCollections(array $col1, array $col2)
    {
        $collectionEquals = true;
        $arrInserts = [];
        $arrUpdates = [];

        foreach($col1 as $elem) {
            $elemInCol2 = false;
            $elemMustUpdate = false;

            /**
            * Compare $rc with all the items of the second collection
            * If the item is not found in the collection, the it must be inserted.
            * If the item is found, it must be compared with the item found. It must be updated if there are fields to be updated,
            **/
            foreach($col2 as $elem2) {
                if($elem->getIdentifier() === $elem2->getIdentifier()) {

                    $elemInCol2 = true;
                    $compareVal = self::equalEntities($elem, $elem2);

                    //check the item has updatable fields
                    if(true !== $compareVal && !empty($compareVal)){
                        $elemMustUpdate = true;
                        break;
                    }

                    break;
                }
            }

            if(!$elemInCol2) {
                $arrInserts[] = $elem;
            } elseif($elemMustUpdate) {
                $arrUpdates[] = $elem;
            }
        }

        return (empty($arrInserts) && empty($arrUpdates)) ? true : [
            "insert" => $arrInserts,
            "update" => $arrUpdates
        ];
    }
}
