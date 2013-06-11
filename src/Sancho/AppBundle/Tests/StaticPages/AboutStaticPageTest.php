<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class AboutStaticPageTest extends PageTestCase
{
    protected $heading = 'About Us';
    protected $pageTitle = 'About Us';

    protected function requestPage()
    {
        return $this->request('GET', 'sancho_app_about');
    }
}
