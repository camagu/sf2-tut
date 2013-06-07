<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class HomeStaticPageTest extends PageTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->crawler = $this->request('GET', 'sancho_app_home');
    }

    public function testHeader()
    {
        $this->assertContains(
            'Sample App',
            $this->crawler->filter('h1')->text()
        );
    }

    public function testTitle()
    {
        $title = $this->crawler->filter('title')->text();

        $this->assertNotContains(' | Home', $title);
        $this->assertContains($this->fullTitle(), $title);
    }
}
