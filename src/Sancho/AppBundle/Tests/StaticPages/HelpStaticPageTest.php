<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class HelpStaticPageTest extends PageTestCase
{
    private $title = 'Help';

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
        $path = $this->getUrl('sancho_app_help');
        return $this->fetchCrawler($path);
    }
}
