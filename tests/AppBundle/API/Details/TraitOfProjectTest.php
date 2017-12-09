<?php

namespace Test\AppBundle\API\Details;

use AppBundle\API\Details\OrganismsOfProject;
use AppBundle\API\Webservice;
use AppBundle\Entity\FennecUser;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\AppBundle\API\WebserviceTestCase;

class TraitOfProjectTest extends WebserviceTestCase
{
    const NICKNAME = 'detailsTraitOfProjectTestUser';
    const USERID = 'detailsTraitOfProjectTestUser';
    const PROVIDER = 'detailsTraitOfProjectTestUser';

    private $em;

    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('app.orm')
            ->getManagerForVersion('test');
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }

    public function testUserNotLoggedIn()
    {
        $default_db = $this->default_db;
        $service = $this->webservice->factory('details', 'traitOfProject');
        $results = $service->execute(new ParameterBag(array('dbversion' => $default_db, 'trait_type_id' => 1, 'internal_project_id' => 3)), null);
        $expected = array("error" => Webservice::ERROR_NOT_LOGGED_IN);
        $this->assertEquals($expected, $results, 'User is not loggend in, return error message');
    }

    public function testTraitsOfProject()
    {
        $default_db = $this->default_db;
        $service = $this->webservice->factory('details', 'traitOfProject');
        $user = $this->em->getRepository('AppBundle:FennecUser')->findOneBy(array(
            'username' => TraitOfProjectTest::NICKNAME
        ));
        $id = $this->em->getRepository('AppBundle:WebuserData')->findOneBy(array(
            'webuser' => $user
        ))->getWebuserDataId();

        $results = $service->execute(new ParameterBag(array('dbversion' => $default_db, 'trait_type_id' => 2, 'internal_project_id' => $id, 'dimension' => 'rows')), $user);
        $expected = [
            "values" => [
                "perennial" => ["1630"],
                "annual" => ["1340"]
            ],
            "trait_type_id" => 2,
            "name" => "Plant Life Cycle Habit",
            "ontology_url" => "http://purl.obolibrary.org/obo/TO_0002725",
            "trait_format" => "categorical_free",
            "number_of_organisms" => 2,
            "description" => "Determined for type of life cycle being annual, biannual, perennial etc. [database_cross_reference: GR:pj]",
            "unit" => null
        ];
        $this->assertEquals($results, $expected, 'Example project, return trait details for rows');

        $results = $service->execute(new ParameterBag(array('dbversion' => $default_db, 'trait_type_id' => 4, 'internal_project_id' => $id, 'dimension' => 'columns')), $user);
        $expected = [
            "values" => [
                "yellow" => ["1340", "1630"]
            ],
            "trait_type_id" => 4,
            "name" => "Flower Color",
            "ontology_url" => "http://purl.obolibrary.org/obo/TO_0000537",
            "trait_format" => "categorical_free",
            "number_of_organisms" => 2,
            "description" => "A flower morphology trait (TO:0000499) which is the color of the flower (PO:0009046)",
            "unit" => null
        ];
        $this->assertEquals($results, $expected, 'Example project, return trait details for columns');
    }

    public function testNoValidUserForProject(){
        $default_db = $this->default_db;
        $noValidProjectId = 20;
        $service = $this->webservice->factory('details', 'traitOfProject');
        $user = $this->em->getRepository('AppBundle:FennecUser')->findOneBy(array(
            'username' => TraitOfProjectTest::NICKNAME
        ));
        $results = $service->execute(new ParameterBag(array('dbversion' => $default_db, 'trait_type_id' => 1, 'internal_project_id' => $noValidProjectId)), $user);
        $expected = array("error" => OrganismsOfProject::ERROR_PROJECT_NOT_FOUND);
        $this->assertEquals($expected, $results, 'Project does not belong to user, return error message');

    }
}
