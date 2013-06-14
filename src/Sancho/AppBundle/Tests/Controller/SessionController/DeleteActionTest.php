<?php

namespace Sancho\AppBundle\Tests\Controller\SessionController;

use Sancho\TestBundle\Test\RequestTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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

        $token = new UsernamePasswordToken($this->user, null, 'main', array('ROLE_USER'));
        $this->get('security.context')->setToken($token);
    }

    public function testLogsUserOut()
    {
        $path = $this->getUrl('sancho_app_session_delete');
        $this->crawler = $this->client->request('GET', $path);

        $this->crawler = $this->client->followRedirect();

        $this->hasLink('Sign out', false);
        $this->hasLink('Sign in');
    }
}
