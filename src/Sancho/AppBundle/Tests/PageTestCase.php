<?php

namespace Sancho\AppBundle\Tests;

use Sancho\AppBundle\Test\RequestTestCase;
use Sancho\AppBundle\Twig\SanchoAppExtension;

abstract class PageTestCase extends RequestTestCase
{
    abstract protected function getHeading();

    abstract protected function getPageTitle();

    abstract protected function requestPage();

    public function testHeadingText()
    {
        $this->assertContains(
            $this->getHeading(),
            $this->requestPage()->filter('h1')->text()
        );
    }

    public function testPageTitleText()
    {
        $this->assertContains(
            $this->fullTitle($this->getPageTitle()),
            $this->requestPage()->filter('title')->text()
        );
    }

    /**
     * @dataProvider layoutLinksProvider
     */
    public function testLayoutLinks($link, $route)
    {
        $crawler = $this->requestPage();
        $this->linkTest($crawler, $link, $route);
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
            array('About', 'sancho_app_about'),
            array('Help', 'sancho_app_help'),
            array('Contact', 'sancho_app_contact'),
            array('Sign in', 'sancho_app_user_new'),
            array('Sample App', 'sancho_app_home'),
        );
    }

}
