<?php

namespace AppBundle\API\Listing;

use AppBundle\Entity\Data\Organism;
use AppBundle\Entity\Data\TraitNumericalEntry;
use AppBundle\Entity\Data\TraitCategoricalEntry;
use AppBundle\Entity\Data\TraitType;
use AppBundle\Entity\User\FennecUser;
use AppBundle\Entity\User\Project;
use AppBundle\Service\DBVersion;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class Overview
{

    private $dataManager;
    private $userManager;

    private $user;
    /**
     * Overview constructor.
     * @param DBVersion $dbversion
     * @param TokenStorage $tokenStorage
     */
    public function __construct(DBVersion $dbversion, TokenStorage $tokenStorage)
    {
        $this->dataManager = $dbversion->getDataEntityManager();;
        $this->userManager = $dbversion->getUserEntityManager();;
        $user = $tokenStorage->getToken()->getUser();
        if (!$user instanceof FennecUser) {
            $user = null;
        }
        $this->user = $user;
    }

    /**
     * @inheritdoc
     *
     * @api {get} /listing/overview Overview
     * @apiName ListingOverview
     * @apiDescription This returns an object containing the number of elements in the database, split by organisms, projects and traits.
     * @apiGroup Listing
     * @apiParam {String} dbversion Version of the internal fennec database
     * @apiVersion 0.8.0
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "projects": 0,
     *       "organisms": 1400000,
     *       "trait_entries": 200000,
     *       "trait_types": 30,
     *     }
     * @apiParamExample {json} Request-Example:
     *     {
     *       "dbversion": "1.0"
     *     }
     * @apiSuccess {Number} projects  Number of projects for the current user.
     * @apiSuccess {Number} organisms  Number of organisms in the database.
     * @apiSuccess {Number} trait_entries  Number of total trait entries in the database.
     * @apiSuccess {Number} trait_types  Number of distinct trait types in the database.
     * @apiExample {curl} Example usage:
     *     curl http://fennec.molecular.eco/api/listing/overview?dbversion=1.0
     * @apiSampleRequest http://fennec.molecular.eco/api/listing/overview
     */
    public function execute(){
        return [
            'projects' => $this->userManager->getRepository(Project::class)->getNumberOfProjects($this->user),
            'organisms' => $this->dataManager->getRepository(Organism::class)->getNumber(),
            'trait_entries' =>
                $this->dataManager->getRepository(TraitCategoricalEntry::class)->getNumber()
                + $this->dataManager->getRepository(TraitNumericalEntry::class)->getNumber(),
            'trait_types' => $this->dataManager->getRepository(TraitType::class)->getNumber(),
        ];

    }
}