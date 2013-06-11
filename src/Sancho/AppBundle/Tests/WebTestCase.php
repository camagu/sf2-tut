<?php

namespace Sancho\AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseTestCase;

class WebTestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    protected function request()
    {
        $args = func_get_args();
        if (isset($args[1]) && !preg_match('/^\\//', $args[1])) {
            $args[1] = $this->generatePath($args[1]);
        }

        return call_user_func_array(array($this->client, 'request'), $args);
    }

    protected function generatePath($routeName)
    {
        return static::createClient()->getContainer()
                                     ->get('router')
                                     ->generate($routeName);
    }

    protected function linkTest($link, $route)
    {
        $link = $this->requestPage()->selectLink($link)->link();
        $this->client->click($link);

        $this->assertEquals(
            $this->generatePath($route),
            $this->client->getRequest()->getRequestUri()
        );
    }
}
