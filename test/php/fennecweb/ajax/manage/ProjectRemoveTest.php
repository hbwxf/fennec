<?php

namespace fennecweb;

class ProjectRemoveTest extends \PHPUnit_Framework_TestCase
{
    const NICKNAME = 'ProjectRemoveTestUser';
    const USERID = 'ProjectRemoveTestUser';
    const PROVIDER = 'ProjectRemoveTestUser';

    public function setUp()
    {
        $_SESSION['user'] = array(
            'nickname' => ProjectRemoveTest::NICKNAME,
            'id' => ProjectRemoveTest::USERID,
            'provider' => ProjectRemoveTest::PROVIDER,
            'token' => 'ProjectRemoveTestUserToken'
        );
    }

    public function testExecute()
    {
        // Test for error returned by empty file
        list($service) = WebService::factory('listing/Projects');
        $entries = ($service->execute(array('dbversion' => DEFAULT_DBVERSION)));
        $this->assertEquals(count($entries['data']), 1);
        $id = $entries['data'][0]['internal_project_id'];
        list($service) = WebService::factory('manage/ProjectRemove');
        $results = ($service->execute(array('dbversion' => DEFAULT_DBVERSION, 'ids' => array($id))));
        list($service) = WebService::factory('listing/Projects');
        $entries = ($service->execute(array('dbversion' => DEFAULT_DBVERSION)));
        $this->assertEquals(count($entries['data']), 0);
    }
}
