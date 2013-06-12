<?php

namespace Sancho\AppBundle\Tests\Controller;

use Sancho\AppBundle\Tests\PageTestCase;

class NewActionTest extends PageTestCase
{
    private $title = 'Sign up';

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
        $path = $this->getUrl('sancho_app_user_new');
        return $this->fetchCrawler($path);
    }
}
