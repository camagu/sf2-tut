<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class ContactStaticPageTest extends PageTestCase
{
    private $title = 'Contact';

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
        $path = $this->getUrl('sancho_app_contact');
        return $this->fetchCrawler($path);
    }
}
