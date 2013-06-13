<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class HomeStaticPageTest extends PageTestCase
{
    protected  function getHeading()
    {
        return 'Sample App';
    }

    protected function getPageTitle()
    {
        return '';
    }

    protected function requestPage()
    {
        $path = $this->getUrl('sancho_app_home');
        return $this->fetchCrawler($path);
    }

    public function testPageTitleShouldNotContainHome()
    {
        $this->assertNotContains(
            'Home',
            $this->requestPage()->filter('title')->text()
        );
    }

    public function testLinkToSignup()
    {
        $this->linkTest('Sign up now!', 'sancho_app_user_new');
    }
}
