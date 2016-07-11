<?php
namespace Comparer;

use Interfaces\Comparable;
use Comparer\Generic as GenericComparer;
use Metadata\RoomCategory as EntityMetadata;

class RoomCategory extends GenericComparer implements Comparable
{
    public static function compareCollections(array $col1, array $col2)
    {
        $collectionEquals = true;
        $arrInserts = [];
        $arrUpdates = [];

        foreach($col1 as $rc) {

            $rcInCol2 = false;
            $rcMustUpdate = false;

            foreach($col2 as $rc2) {
                if($rc1->getIdAtProvider() === $rc2->getIdAtProvider()) {

                    $compareVal = self::equalEntities($rc, $rc2);

                    if(true !== $compareVal && !empty($compareVal)){
                        break;
                    }

                    break;
                }
            }

            if(!$rcInCol2) {
                $arrInserts[] = $rc;
            } elseif($rcMustUpdate) {
                $arrUpdates[] = $rc;
            }
        }

        return (empty($arrInserts) && empty($arrUpdates)) ? true : [
            'insert' => $arrInserts,
            'update' => $arrUpdates
        ];
    }
}
