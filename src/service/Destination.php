<?php
namespace Service;

use Entity\Price as PriceEntity;
use Metadata\Price as PriceMetadata;

class Destination extends Generic
{
    public function sync($destinationsArr) 
    {
        $providerId = $this->getProviderData()['id'];
        $destinationsCount = 0;
        foreach($destinationsArr as $data) {
            $this->getDb()->insert('destination', [
                'provider_id' => $providerId,
                'id_at_provider' => $data->Id,
                'name' => $data->Name
            ]);

            $destinationsCount++;
        }

        return $destinationsCount;
    }

    public function updateDestinationsOffers()
    {

        //reset previous counters
        $this->getDb()->executeQuery("UPDATE destination SET hotels_no = 0, circuits_no = 0, packages_no = 0, total_offers = 0");

        $sql = "
            SELECT 
                p.destination_id, COUNT(*) as total
            FROM
                package p
            GROUP BY p.destination_id
        ";

        $data = $this->getDb()->fetchAll($sql);

        $updateQ = "INSERT INTO destination (id_at_provider, total_offers) VALUES ";

        foreach($data as $arr) {
            $updateQ .= "(".implode(",",$arr)."),";
        }

        $updateQ = rtrim($updateQ, ",");

        $updateQ .= " ON DUPLICATE KEY UPDATE total_offers=VALUES(total_offers);";

        $this->getDb()->executeQuery($updateQ);

    }
}
