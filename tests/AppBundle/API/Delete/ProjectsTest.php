<?php

namespace Tests\AppBundle\API\Delete;

use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\AppBundle\API\WebserviceTestCase;
use AppBundle\Entity\WebuserData;
use AppBundle\API\Delete;
use AppBundle\API\Listing;

class ProjectsTest extends WebserviceTestCase 
{
    const NICKNAME = 'ProjectRemoveTestUser';
    const USERID = 'ProjectRemoveTestUser';
    const PROVIDER = 'ProjectRemoveTestUser';

    private $em;
    private $deleteProject;
    private $listingProject;

    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager('test');
        $this->deleteProject = $kernel->getContainer()->get(Delete\Projects::class);
        $this->listingProject = $kernel->getContainer()->get(Listing\Projects::class);

    }

    public function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }

    public function testBeforeDelete(){
        $user = $this->em->getRepository('AppBundle:FennecUser')->findOneBy(array(
            'username' => ProjectsTest::NICKNAME
        ));
        $projectListing = $this->em->getRepository(WebuserData::class)->getDataForUser($user->getId());
        $this->assertEquals(1, count($projectListing));
    }

    /**
     * @depends testBeforeDelete
     */
    public function testDelete(){
        $user = $this->em->getRepository('AppBundle:FennecUser')->findOneBy(array(
            'username' => ProjectsTest::NICKNAME
        ));
        $project = $this->em->getRepository(WebuserData::class)->getDataForUser($user->getId());
        $projectId = $project[0]['webuserDataId'];
        $expected = array("deletedProjects"=>1);
        $results = $this->deleteProject->execute($user, $projectId);
        $this->assertEquals($expected, $results);
    }

    /**
     * @depends testDelete
     */
    public function testAfterDelete(){
        $user = $this->em->getRepository('AppBundle:FennecUser')->findOneBy(array(
            'username' => ProjectsTest::NICKNAME
        ));
        $projectListing = $this->webservice->factory('listing', 'projects');
        $entries = $projectListing->execute(
            new ParameterBag(
                array('dbversion' => $this->default_db)
            ),
            $user
        );
        $this->assertEquals(0, count($entries['data']));
    }
}
