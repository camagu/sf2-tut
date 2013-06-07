<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class ContactStaticPageTest extends PageTestCase
{
    public function testHeader()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertContains(
            'Contact',
            $crawler->filter('h1')->text()
        );
    }

    public function testTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertContains(
            "{$this->baseTitle} | Contact",
            $crawler->filter('title')->text()
        );
    }
}
