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
    /**
     * @todo Create custom assert
     */
    protected function linkTest($link, $route)
    {
        $link = $this->crawler->selectLink($link)->link();
        $this->client->click($link);

        $this->assertEquals(
            $this->getUrl($route),
            $this->client->getRequest()->getRequestUri()
        );
    }
}
