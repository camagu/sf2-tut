<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class HelpStaticPageTest extends PageTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->crawler = $this->request('GET', 'sancho_app_help');
    }

    public function testHeader()
    {
        $this->assertContains(
            'Help',
            $this->crawler->filter('h1')->text()
        );
    }

    public function testTitle()
    {
        $this->assertContains(
            $this->fullTitle('Help'),
            $this->crawler->filter('title')->text()
        );
    }
}
