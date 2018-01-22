<?php

namespace AppBundle\API\Mapping;

use AppBundle\Entity\FennecUser;
use AppBundle\Service\DBVersion;
use Symfony\Component\HttpFoundation\ParameterBag;

class ByOrganismName
{
    private $manager;

    /**
     * ByOrganismName constructor.
     * @param $dbversion
     */
    public function __construct(DBVersion $dbversion)
    {
        $this->manager = $dbversion->getEntityManager();
    }


    /**
     * @inheritdoc
     */
    public function execute($ids)
    {
        return $this->manager->getRepository('AppBundle:Organism')->getFennecIdsToScientificNames($ids);
    }
}