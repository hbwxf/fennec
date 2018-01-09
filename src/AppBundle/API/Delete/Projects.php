<?php

namespace AppBundle\API\Delete;

use AppBundle\API\Webservice;
use AppBundle\AppBundle;
use AppBundle\Entity\WebuserData;
use AppBundle\Entity\FennecUser;
use AppBundle\Service\DBVersion;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Web Service.
 * Delete Project with given internal_ids from the database (user has to be logged in and owner)
 */
class Projects
{
    private $manager;

    /**
     * Projects constructor.
     * @param $dbversion
     */
    public function __construct(DBVersion $dbversion)
    {
        $this->manager = $dbversion->getEntityManager();
    }


    /**
    * @inheritdoc
    * <code>
    * array('dbversion'=>$dbversion, 'ids'=>array($id1, $id2));
    * </code>
    * @returns array $result
    * <code>
    * array(array('project_id','import_date','OTUs','sample size'));
    * </code>
    */
    public function execute(FennecUser $user = null)
    {
        $manager = $this->getManagerFromQuery($query);
        $result = array('deletedProjects' => 0);
        if ($user === null) {
            $result['error'] = Webservice::ERROR_NOT_LOGGED_IN;
        } else {
            $projects = $user->getData()->filter(function (WebuserData $p) use($query){
                return in_array($p->getWebuserDataId(), $query->get('ids'));
            });
            foreach($projects as $project){
                $project = $manager->merge($project);
                $manager->remove($project);
            }
            $manager->flush();

            $result['deletedProjects'] = count($projects);
        }
        return $result;
    }
}
