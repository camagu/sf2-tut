<?php

namespace Sancho\AppBundle\Tests\Fixtures;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class DummySecurityContext implements SecurityContextInterface
{
    private $token;

    public function getToken()
    {
        return $this->token;
    }

    public function setToken(TokenInterface $token = null)
    {
        $this->token = $token;
    }

    public function isGranted($attributes, $object = null)
    {
        return;
    }
}
