<?php

namespace Sancho\AppBundle\Test;

class RequestTestCase extends BaseTestCase
{
    protected $client;
    protected $crawler;

    public function setUp()
    {
        parent::setUp();
        $this->client = $this->makeClient();
    }

    protected function hasLink($label, $success = true)
    {
        $links = $this->crawler->selectLink($label);

        if ($success) {
            $this->assertGreaterThan(0, $links->count(), "Link {$label} doesn't exists");
            return $links->link();
        } else {
            $this->assertEquals(0, $links->count(), "Link {$label} exists");
        }
    }

    protected function doesLinkPointsTo($label, $path, $success = true)
    {
        $link = $this->hasLink($label, $success);
        $href = $link->getNode()->attributes->getNamedItem('href')->nodeValue;

        if ($success) {
            $this->assertEquals($path, $href, "Link's href {$href} is not equal to {$path}");
        } else {
            $this->assertNotEquals($path, $href, "Link's href {$href} is equal to {$path}");
        }

        return $link;
    }
}
