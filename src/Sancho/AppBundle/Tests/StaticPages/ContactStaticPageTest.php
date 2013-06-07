<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class ContactStaticPageTest extends PageTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->crawler = $this->request('GET', 'sancho_app_contact');
    }

    public function testHeader()
    {
        $this->assertContains(
            'Contact',
            $this->crawler->filter('h1')->text()
        );
    }

    public function testTitle()
    {
        $this->assertContains(
            $this->fullTitle('Contact'),
            $this->crawler->filter('title')->text()
        );
    }
}
