<?php

namespace Sancho\AppBundle\Tests\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sancho\AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Dummy Me');
        $user->setEmail('my@email.loc');
        $user->setPassword('123456');

        $manager->persist($user);
        $manager->flush();
    }
}
