<?php

namespace Sancho\AppBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase
{
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    protected function getContainer()
    {
        return $this->getClient()->getContainer();
    }

    protected function get($id)
    {
        return $this->getContainer()->get($id);
    }

    protected function getClient()
    {
        return $this->client;
    }
}
