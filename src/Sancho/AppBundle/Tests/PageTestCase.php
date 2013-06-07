<?php

namespace Sancho\AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageTestCase extends WebTestCase
{
    protected $baseTitle = 'Symfony2 Tutorial Sample App';

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    protected function request($method, $route)
    {
        return $this->client->request($method, $this->path($route));
    }

    protected function path($routeName)
    {
        return static::createClient()->getContainer()
                                     ->get('router')
                                     ->generate($routeName);
    }

    protected function fullTitle($title = '')
    {
        return $this->baseTitle . ($title ? " | {$title}" : '');
    }
}
