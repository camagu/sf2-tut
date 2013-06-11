<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class HelpStaticPageTest extends PageTestCase
{
    protected $heading = 'Help';
    protected $pageTitle = 'Help';

    protected function requestPage()
    {
        return $this->request('GET', 'sancho_app_help');
    }
}
