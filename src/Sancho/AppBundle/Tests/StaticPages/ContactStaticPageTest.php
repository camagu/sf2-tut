<?php

namespace Sancho\AppBundle\Tests\StaticPages;

use Sancho\AppBundle\Tests\PageTestCase;

class ContactStaticPageTest extends PageTestCase
{
    protected $heading = 'Contact';
    protected $pageTitle = 'Contact';

    protected function requestPage()
    {
        return $this->request('GET', 'sancho_app_contact');
    }
}
