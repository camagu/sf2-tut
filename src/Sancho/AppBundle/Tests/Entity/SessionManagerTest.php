<?php

namespace Sancho\AppBundle\Tests\Entity;

use Sancho\AppBundle\Entity\SessionManager;
use Sancho\AppBundle\Tests\Fixtures\DummySecurityContext;
use Sancho\TestBundle\Test\BaseTestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SessionManagerTest extends BaseTestCase
{
    protected $fixtures = array(
        'Sancho\AppBundle\Tests\Fixtures\LoadUserData',
    );

    public function setUp()
    {
        parent::setUp();

        $this->securityContext = new DummySecurityContext();
        $this->providerKey = 'auth';

        $this->sessionManager = new SessionManager($this->securityContext, $this->providerKey);

        $this->user = $this->get('doctrine')
            ->getRepository('SanchoAppBundle:User')
            ->findOneBy(array());
    }

    public function testLogin()
    {
        $this->sessionManager->login($this->user);

        $token = $this->securityContext->getToken();

        $this->assertNotEmpty($token);
        $this->assertEquals($this->providerKey, $token->getProviderKey());

        $roles = array();
        foreach ($token->getRoles() as $role) {
            $roles[] = $role->getRole();
        }

        $this->assertEquals($this->user->getRoles(), $roles);
    }

    public function testCurrentUser()
    {
        $this->sessionManager->login($this->user);
        $this->assertEquals(
            $this->user,
            $this->sessionManager->getCurrentUser()
        );
    }
}
