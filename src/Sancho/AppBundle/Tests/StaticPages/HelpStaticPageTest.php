<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class HelpStaticPageTest extends PageTestCase
{
    public function testHeader()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/help');

        $this->assertContains(
            'Help',
            $crawler->filter('h1')->text()
        );
    }

    public function testTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/help');

        $this->assertContains(
            "{$this->baseTitle} | Help",
            $crawler->filter('title')->text()
        );
    }
}
