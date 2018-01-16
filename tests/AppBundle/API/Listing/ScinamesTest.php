<?php

namespace Tests\AppBundle\API\Listing;

use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\AppBundle\API\WebserviceTestCase;
use AppBundle\API\Listing;

class ScinamesTest extends WebserviceTestCase
{
    private $em;
    private $listingScinames;

    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager('test');
        $this->listingScinames = $kernel->getContainer()->get(Listing\Scinames::class);

    }

    public function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
    public function testExecute()
    {
        $organisms = $this->webservice->factory('listing', 'scinames');
        $parameterBag = new ParameterBag(array('dbversion' => $this->default_db, 'ids' => [5,43,234,6432,32421,120121]));
        $results = $organisms->execute($parameterBag, null);
        $expected = array(
            "5" => "Chlorophyta",
            "43" => "green alga KS3/2",
            "234" => "Ginkgoales",
            "6432" => "Coffea sp. X",
            "32421" => "Detarieae",
            "120121" => "Campanula takesimana"
        );
        $this->assertEquals($expected, $results);
    }

    public function testExecuteNoIds()
    {
        $organisms = $this->webservice->factory('listing', 'scinames');
        $parameterBag = new ParameterBag(array('dbversion' => $this->default_db));
        $results = $organisms->execute($parameterBag, null);
        $expected = array();
        $this->assertEquals($expected, $results);
    }
}