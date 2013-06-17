<?php

namespace Sancho\AppBundle\Entity;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SessionManager
{
    private $securityContext;
    private $providerKey;

    public function __construct(SecurityContextInterface $securityContext, $providerKey = 'main')
    {
        $this->securityContext = $securityContext;
        $this->providerKey = $providerKey;
    }

    public function login($user)
    {
        $roles = $user->getRoles();
        $token = new UsernamePasswordToken($user, null, $this->providerKey, $roles);
        $this->securityContext->setToken($token);
    }

    public function getCurrentUser()
    {
        $token = $this->securityContext->getToken();
        if ($token) {
            return $token->getUser();
        }
    }
}
