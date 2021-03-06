<?php

namespace AppBundle\API\Details;

use AppBundle\Entity\Data\Organism;
use AppBundle\Service\DBVersion;

/**
 * Web Service.
 * Returns details for Organisms with given ids
 */
class Organisms
{

    private $manager;

    /**
     * Organism constructor.
     * @param $dbversion
     */
    public function __construct(DBVersion $dbversion)
    {
        $this->manager = $dbversion->getDataEntityManager();
    }


    /**
     * @param $fennecId
     * @returns array of details
     */
    public function execute($fennecId)
    {
        return $this->manager->getRepository(Organism::class)->getDetailsOfOrganism($fennecId);
    }
}
