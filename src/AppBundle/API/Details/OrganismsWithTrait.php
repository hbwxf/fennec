<?php

namespace AppBundle\API\Details;

use AppBundle\API\Webservice;
use AppBundle\Entity\FennecUser;
use AppBundle\Entity\Organism;
use AppBundle\Service\DBVersion;
use \PDO as PDO;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Web Service.
 * Returns Organisms that posess a given trait
 */
class OrganismsWithTrait
{
    const DEFAULT_LIMIT = 100;

    private $manager;

    /**
     * OrganismsWithTrait constructor.
     * @param $dbversion
     */
    public function __construct(DBVersion $dbversion)
    {
        $this->manager = $dbversion->getEntityManager();
    }


    public function execute($trait_type_id)
    {
        return $this->manager->getRepository(Organism::class)->getOrganismByTrait($trait_type_id);
    }
}
