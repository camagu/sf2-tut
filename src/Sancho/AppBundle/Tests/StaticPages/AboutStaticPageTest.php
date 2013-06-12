<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class AboutStaticPageTest extends PageTestCase
{
    private $title = 'About Us';

    protected  function getHeading()
    {
        return $this->title;
    }

    protected function getPageTitle()
    {
        return $this->title;
    }

    protected function requestPage()
    {
        $path = $this->getUrl('sancho_app_about');
        return $this->fetchCrawler($path);
    }
}
