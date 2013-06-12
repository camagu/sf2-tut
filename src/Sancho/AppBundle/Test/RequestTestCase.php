<?php

namespace Sancho\AppBundle\Test;

class RequestTestCase extends BaseTestCase
{
    /**
     * @todo Create custom assert
     */
    protected function linkTest($crawler, $link, $route)
    {
        $link = $crawler->selectLink($link)->link();

        $client = $this->makeClient();
        $client->click($link);

        $this->assertEquals(
            $this->getUrl($route),
            $client->getRequest()->getRequestUri()
        );
    }
}
