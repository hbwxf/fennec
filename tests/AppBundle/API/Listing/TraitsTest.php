<?php

namespace Tests\AppBundle\API\Listing;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class TraitsTest extends WebTestCase
{

    public function testExecute()
    {
        $client = self::createClient();
        $default_db = $client->getContainer()->getParameter('default_db');
        $service = $client->getContainer()->get('app.api.webservice')->factory('listing', 'traits');
        $results = $service->execute(
            new ParameterBag(array('dbversion' => $default_db, 'search' => '')),
            null
        );
        $expected = array(
            array(
                "name" => "PlantHabit",
                "trait_type_id" => 1,
                "frequency" => 48916
            )
        );
        $this->assertEquals($expected, $results, 'Search without term and limit, result should be a list of all traits');

        $results = $service->execute(
            new ParameterBag(array('dbversion' => DEFAULT_DBVERSION, 'search' => 'SomethingThatWillNeverBeATraitType')),
            null
        );
        $expected = array();
        $this->assertEquals($expected, $results, 'Search term does not hit, result should be an empty array');
    }
}
