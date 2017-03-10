<?php

namespace Tests\AppBundle\API;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebserviceTestCase extends WebTestCase
{
    protected $container;
    protected $default_db;
    protected $webservice;
    protected $user;

    public function __construct()
    {
        $this->container = static::createClient()->getContainer();
        $this->default_db = $this->container->getParameter('dbal')['default_connection'];
        $this->webservice = $this->container->get('app.api.webservice');
        $this->user = null;
    }
}
