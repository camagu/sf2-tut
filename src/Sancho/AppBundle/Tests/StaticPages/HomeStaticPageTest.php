<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class HomeStaticPageTest extends PageTestCase
{
    public function testHeader()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertContains(
            'Sample App',
            $crawler->filter('h1')->text()
        );
    }

    public function testTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $title = $crawler->filter('title')->text();

        $this->assertNotContains(' | Home', $title);
        $this->assertContains($this->baseTitle, $title);
    }
}
