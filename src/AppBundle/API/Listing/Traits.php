<?php

namespace AppBundle\API\Listing;

use AppBundle\API\Webservice;
use AppBundle\Entity\FennecUser;
use AppBundle\Entity\TraitCategoricalEntry;
use AppBundle\Entity\TraitNumericalEntry;
use AppBundle\Service\DBVersion;
use \PDO as PDO;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Web Service.
 * Returns Trait information
 */
class Traits
{
    private $manager;

    /**
     * Traits constructor.
     * @param $dbversion
     */
    public function __construct(DBVersion $dbversion)
    {
        $this->manager = $dbversion->getEntityManager();
    }


    /**
     * @param $limit Integer
     * @param $search String_
     * @returns array of traits
     */
    public function execute($limit, $search)
    {
        $categoricalTraits = $this->manager->getRepository(TraitCategoricalEntry::class)->getTraits($search, $limit);
        $numericalTraits = $this->manager->getRepository(TraitNumericalEntry::class)->getTraits($search, $limit);
        $data = array_merge($numericalTraits, $categoricalTraits);
        //if performance-tuning is required:
        //Merge-Step of MergeSort would be sufficient but not natively available in PHP
        usort($data, function($a,$b){return $b['frequency'] - $a['frequency'];});
        return $data;
    }

    /**
     * @param $db
     * @param $search
     * @param $limit
     * @param $trait_format
     * @return array
     */
    private function get_traits($db, $search, $limit, $trait_format)
    {
        $query_get_traits = <<<EOF
SELECT trait_type.type AS name, trait_type_id, count
    FROM 
        (
            SELECT trait_type_id, count(trait_type_id) AS count
EOF;
        $query_get_traits .= " FROM trait_".$trait_format."_entry WHERE deletion_date IS NULL GROUP BY trait_type_id";

        $query_get_traits .= <<<EOF
        ) AS trait_entry, trait_type
            WHERE trait_type.id=trait_type_id AND trait_type.type ILIKE :search ORDER BY count DESC LIMIT :limit
EOF;
        $stm_get_traits = $db->prepare($query_get_traits);
        $stm_get_traits->bindValue('search', $search);
        $stm_get_traits->bindValue('limit', $limit);
        $stm_get_traits->execute();

        $data = array();
        while ($row = $stm_get_traits->fetch(PDO::FETCH_ASSOC)) {
            $result = array();
            $result['name'] = $row['name'];
            $result['trait_type_id'] = $row['trait_type_id'];
            $result['frequency'] = $row['count'];
            $data[] = $result;
        }
        return $data;
    }
}
