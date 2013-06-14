<?php

namespace Sancho\TestBundle\Test;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase
{
    protected $fixtures = array();

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures($this->fixtures);
    }

    public function get($id)
    {
        return $this->getContainer()->get($id);
    }
}
