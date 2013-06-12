<?php

namespace Sancho\AppBundle\Test;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function get($id)
    {
        return $this->getContainer()->get($id);
    }
}
