<?php

namespace Sancho\AppBundle\Tests;

use Sancho\TestBundle\Test\RequestTestCase;
use Sancho\AppBundle\Twig\SanchoAppExtension;

abstract class PageTestCase extends RequestTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->init();
        $this->crawler = $this->requestPage();
    }

    protected function init()
    {

    }

    abstract protected function getHeading();

    abstract protected function getPageTitle();

    abstract protected function requestPage();

    public function testHeadingText()
    {
        $this->assertContains(
            $this->getHeading(),
            $this->crawler->filter('h1')->text()
        );
    }

    public function testPageTitleText()
    {
        $this->assertContains(
            $this->fullTitle($this->getPageTitle()),
            $this->crawler->filter('title')->text()
        );
    }

    /**
     * @dataProvider layoutLinksProvider
     */
    public function testLayoutLinks($link, $route)
    {
        $this->doesLinkPointsTo($link, $route);
    }

    protected function fullTitle($title = '')
    {
        $twig = new \Twig_Environment(new \Twig_Loader_String(), array('cache' => false));
        $twig->addExtension(new SanchoAppExtension());

        $template = $twig->loadTemplate("{{ full_title(title) }}");

        return $template->render(array('title' => $title));
    }

    public function layoutLinksProvider()
    {
        return array(
            array('About',      $this->getUrl('sancho_app_about')),
            array('Help',       $this->getUrl('sancho_app_help')),
            array('Contact',    $this->getUrl('sancho_app_contact')),
            array('Sign in',    $this->getUrl('sancho_app_session_new')),
            array('Sample App', $this->getUrl('sancho_app_home')),
        );
    }
}
