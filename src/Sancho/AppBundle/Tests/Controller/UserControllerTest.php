<?php

namespace Sancho\AppBundle\Tests\Controller;

use Sancho\AppBundle\Tests\PageTestCase;

class UserControllerTest extends PageTestCase
{
    protected $heading = 'Sign up';
    protected $pageTitle = 'Sign up';

    protected function requestPage()
    {
        return $this->request('GET', 'sancho_app_user_new');
    }
}
