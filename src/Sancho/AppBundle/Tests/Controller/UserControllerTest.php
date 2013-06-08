<?php

namespace Sancho\AppBundle\Tests\Controller;

use Sancho\AppBundle\Tests\PageTestCase;

class UserControllerTest extends PageTestCase
{
    public function testCreateHeader()
    {
        $crawler = $this->request('GET', 'sancho_app_user_create');
        $this->assertContains(
            'Sign up',
            $crawler->filter('h1')->text()
        );
    }

    public function testCreateTitle()
    {
        $crawler = $this->request('GET', 'sancho_app_user_create');
        $this->assertContains(
            $this->fullTitle('Sign up'),
            $crawler->filter('title')->text()
        );
    }
}
