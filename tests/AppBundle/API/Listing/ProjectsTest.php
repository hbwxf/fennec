<?php

namespace Tests\AppBundle\API\Listing;

use AppBundle\API\Webservice;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ProjectsTest extends WebTestCase
{
    const NICKNAME = 'listingProjectsTestUser';
    const USERID = 'listingProjectsTestUser';
    const PROVIDER = 'listingProjectsTestUser';

    public function testExecute()
    {
        $container = static::createClient()->getContainer();
        $default_db = $container->getParameter('default_db');
        $service = $container->get('app.api.webservice')->factory('listing', 'projects');
        $session = new Session(new MockArraySessionStorage());

        //Test for error returned by user is not logged in
        $results = $service->execute(
            new ParameterBag(array('dbversion' => $default_db)),
            $session
        );
        $expected = array("error" => Webservice::ERROR_NOT_LOGGED_IN, "data" => array());
        
        $this->assertEquals($expected, $results);
        
        //Test of correct project if the user has only one project
        $session->set('user', array(
            'nickname' => ProjectsTest::NICKNAME,
            'id' => ProjectsTest::USERID,
            'provider' => ProjectsTest::PROVIDER,
            'token' => 'listingProjectsTestUserToken'
        ));
        $results = $service->execute(
            new ParameterBag(array('dbversion' => $default_db)),
            $session
        );
        $expected = array("data" => array(
                array(
                    "id" => "table_1",
                    "import_date" => "2016-05-17 10:00:52.627236+00",
                    "rows" => 10,
                    "columns" => 5,
                    "import_filename" => "listingProjectsTestFile.biom"
                )
            )
        );
        $this->assertArraySubset($expected, $results);
    }
}
