<?php

namespace Tests\AppBundle\API\Edit;

use AppBundle\API\Edit\AddOrganismIDsToProject;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\AppBundle\API\WebserviceTestCase;

class AddOrganismIDsToProjectTest extends WebserviceTestCase
{
    const NICKNAME = 'AddOrganismIDsToProjectTestUser';
    const USERID = 'AddOrganismIDsToProjectTestUser';
    const PROVIDER = 'AddOrganismIDsToProjectTest';

    public function testExecute()
    {
        $default_db = $this->default_db;
        $service = $this->webservice->factory('edit', 'addOrganismIDsToProject');
        $uploadProject = $this->webservice->factory('upload', 'projects');
        $listingProject = $this->webservice->factory('listing', 'projects');
        $detailsProject = $this->webservice->factory('details', 'projects');
        $session = $this->session;
        $session->set('user',
            array(
                'nickname' => AddOrganismIDsToProjectTest::NICKNAME,
                'id' => AddOrganismIDsToProjectTest::USERID,
                'provider' => AddOrganismIDsToProjectTest::PROVIDER,
                'token' => 'AddOrganismIDsToProjectTestUserToken'
            )
        );
        $_FILES = array(
            array(
                'name' => 'empty',
                'type' => 'text/plain',
                'size' => 0,
                'tmp_name' => __DIR__ . '/testFiles/addOrganismIDsToProjectTest.json',
                'error' => 0
            )
        );
        $uploadProject->execute(new ParameterBag(array('dbversion' => $default_db)), $session);
        $entries = $listingProject->execute(new ParameterBag(array('dbversion' => $default_db)), $session);
        $id = $entries['data'][0]['internal_project_id'];
        # Test for unknown method error
        $results = $service->execute(new ParameterBag(
            array(
                'dbversion' => $default_db,
                'id' => $id,
                'method' => 'unknown_method_that_does_not_exist'
            )
        ), $session);
        $this->assertEquals(AddOrganismIDsToProject::ERROR_UNKNOWN_METHOD, $results['error']);

        # Test for successful ncbi_taxid method
        $results = $service->execute(new ParameterBag(
            array(
                'dbversion' => $default_db,
                'id' => $id,
                'method' => 'ncbi_taxid'
            )
        ), $session);
        $this->assertEquals(10, $results['success']);

        $results = $detailsProject->execute(new ParameterBag(array(
            'dbversion' => $default_db,
            'ids' => array($id))),
            $session
        );
        $rows = json_decode($results['projects'][$id], true)['rows'];
        $ncbi_taxid = function ($row) {
            return($row['metadata']['ncbi_taxid']);
        };
        $actual_ncbi_taxids = array_map($ncbi_taxid, $rows);
        $organism_id = function ($row) {
            return($row['metadata']['fennec_organism_id']);
        };
        $actual_organism_ids = array_map($organism_id, $rows);
        $expect_ncbi_taxids = array(722820,471708,1671960,634075,1137923,279054,267236,133362,161435,690802);
        $expect_organism_ids = array(16,17,18,21,23,26,27,30,31,32);
        $this->assertEquals($expect_ncbi_taxids, $actual_ncbi_taxids);
        $this->assertEquals($expect_organism_ids, $actual_organism_ids);
        $this->assertEquals('ncbi_taxid', $rows[3]['metadata']['fennec_assignment_method']);
        $this->assertEquals($default_db, $rows[7]['metadata']['fennec_dbversion']);
    }
}
