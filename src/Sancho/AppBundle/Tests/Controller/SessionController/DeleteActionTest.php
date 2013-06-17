<?php

namespace Sancho\AppBundle\Tests\Controller\SessionController;

use Sancho\TestBundle\Test\RequestTestCase;

class DeleteActionTest extends RequestTestCase
{
    protected $fixtures = array(
        'Sancho\AppBundle\Tests\Fixtures\LoadUserData'
    );

    public function setUp()
    {
        parent::setUp();

        $this->user = $this->get('doctrine')
            ->getRepository('SanchoAppBundle:User')
            ->findOneBy(array());

        $this->user->setPlainPassword('password');
        $userManager = $this->get('sancho_app.user_manager');
        $userManager->updateUser($this->user);

        $sessionManager = $this->get('sancho_app.session_manager');
        $sessionManager->login($this->user);
    }

    public function testLogsUserOut()
    {
        $this->assertNotEmpty(
            $this->get('security.context')->getToken()
        );

        $path = $this->getUrl('sancho_app_session_delete');
        $this->crawler = $this->client->request('GET', $path);

        $this->crawler = $this->client->followRedirect();

        $this->hasLink('Sign out', false);
        $this->hasLink('Sign in');
    }
}
