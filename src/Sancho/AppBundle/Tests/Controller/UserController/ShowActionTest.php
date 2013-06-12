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

        $this->loadFixtures(array(
            'Sancho\AppBundle\Tests\Fixtures\LoadUserData',
        ));

        $this->user = $this->get('doctrine')
            ->getRepository('SanchoAppBundle:User')
            ->findOneBy(array());
    }

    protected  function getHeading()
    {
        return $this->getPageTitle();
    }

    protected function getPageTitle()
    {
        return $this->user->getName();
    }

    protected function requestPage()
    {
        $path = $this->getUrl('sancho_app_user_show', array('id' => $this->user->getId()));
        return $this->fetchCrawler($path);
    }
}
