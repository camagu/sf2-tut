<?php

namespace Sancho\AppBundle\Tests\Controller;

use Sancho\AppBundle\Entity\User;
use Sancho\AppBundle\Tests\Fixtures\UserFixture;
use Sancho\AppBundle\Tests\PageTestCase;

class ShowActionTest extends PageTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = UserFixture::single();
        $this->getEntityManager()->persist($this->user);
        $this->getEntityManager()->flush();

        $this->heading = $this->pageTitle = $this->user->getName();
    }

    protected function requestPage()
    {
        $path = $this->generatePath('sancho_app_user_show', array('id' => $this->user->getId()));
        return $this->request('GET', $path);
    }
}
