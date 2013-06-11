<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class HomeStaticPageTest extends PageTestCase
{
    protected $heading = 'Sample App';
    protected $pageTitle = '';

    protected function requestPage()
    {
        return $this->request('GET', 'sancho_app_home');
    }

    public function testPageTitleShouldNotContainHome()
    {
        $this->assertNotContains(
            'Home',
            $this->requestPage()->filter('title')->text()
        );
    }
}
