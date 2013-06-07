<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class AboutStaticPageTest extends PageTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->crawler = $this->request('GET', 'sancho_app_about');
    }

    public function testHeader()
    {
        $this->assertContains(
            'About Us',
            $this->crawler->filter('h1')->text()
        );
    }

    public function testTitle()
    {
        $this->assertContains(
            $this->fullTitle('About Us'),
            $this->crawler->filter('title')->text()
        );
    }
}
