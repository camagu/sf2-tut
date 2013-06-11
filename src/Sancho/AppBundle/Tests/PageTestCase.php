<?php

namespace Sancho\AppBundle\Tests;

use Sancho\AppBundle\Twig\SanchoAppExtension;

abstract class PageTestCase extends WebTestCase
{
    public function testHeadingText()
    {
        if (!isset($this->heading)) {
            throw new \Exception("Must declare \$heading in ".get_class($this));
        }

        $this->assertContains(
            $this->heading,
            $this->requestPage()->filter('h1')->text()
        );
    }

    public function testPageTitleText()
    {
        if (!isset($this->pageTitle)) {
            throw new \Exception("Must declare \$pageTitle in ".get_class($this));
        }

        $this->assertContains(
            $this->fullTitle($this->pageTitle),
            $this->requestPage()->filter('title')->text()
        );
    }

    /**
     * @dataProvider layoutLinksProvider
     */
    public function testLayoutLinks($link, $expected)
    {
        $link = $this->requestPage()->selectLink($link)->link();
        $this->client->click($link);

        $this->assertEquals(
            $expected,
            $this->client->getRequest()->getRequestUri()
        );
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
            array('About', $this->generatePath('sancho_app_about')),
            array('Help', $this->generatePath('sancho_app_help')),
            array('Contact', $this->generatePath('sancho_app_contact')),
            array('Sign in', $this->generatePath('sancho_app_user_create')),
            array('Sample App', $this->generatePath('sancho_app_home')),
        );
    }

    abstract protected function requestPage();
}
