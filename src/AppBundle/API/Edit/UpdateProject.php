<?php

namespace AppBundle\API\Edit;


use AppBundle\API\Webservice;
use AppBundle\AppBundle;
use AppBundle\Entity\User\FennecUser;
use AppBundle\Entity\User\WebuserData;
use AppBundle\Service\DBVersion;
use Symfony\Component\HttpFoundation\ParameterBag;

class UpdateProject
{
    private $manager;

    /**
     * UpdateProject constructor.
     * @param $dbversion
     */
    public function __construct(DBVersion $dbversion)
    {
        $this->manager = $dbversion->getUserEntityManager();
    }


    /**
     * @inheritdoc
     */
    public function execute($projectId, $biom, FennecUser $user = null)
    {
        $biom = json_decode($biom, true);
        if($biom === null || $projectId === null){
            return array('error' => 'Missing parameter "biom" or "projectId"');
        }
        if($user == null){
            return array('error' => 'User not logged in');
        }
        if($user === null){
            return array('error' => 'Could not update project. Not found for user.');
        }
        $project = $this->manager->getRepository(WebuserData::class)->findOneBy(array('webuser' => $user, 'webuserDataId' => $projectId));
        if($project === null){
            return array('error' => 'Could not update project. Not found for user.');
        }
        $project->setProject($biom);
        $this->manager->persist($project);
        $this->manager->flush();
        return array('error' => null);
    }
}