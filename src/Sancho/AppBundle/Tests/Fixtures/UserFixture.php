<?php

namespace Sancho\AppBundle\Tests\Fixtures;

use Sancho\AppBundle\Entity\User;

class UserFixture
{
    static public function single()
    {
        $user = new User();
        $user->setName('Example User');
        $user->setEmail('user@example.loc');
        $user->setPassword('asdf1238');

        return $user;
    }
}
