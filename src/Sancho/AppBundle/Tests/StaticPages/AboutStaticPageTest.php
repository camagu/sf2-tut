<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class AboutStaticPageTest extends PageTestCase
{
    public function testHeader()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/about');

        $this->assertContains(
            'About Us',
            $crawler->filter('h1')->text()
        );
    }

    public function testTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/about');

        $this->assertContains(
            "{$this->baseTitle} | About Us",
            $crawler->filter('title')->text()
        );
    }
}
