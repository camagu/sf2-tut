<?php

namespace Sancho\AppBundle\Tests\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Sancho\AppBundle\Entity\User;

class LoadUserData extends ContainerAware implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Dummy Me');
        $user->setEmail('my@email.loc');
        $user->setPlainPassword('12345678');

        $this->container
            ->get('sancho_app.user_manager')
            ->createUser($user);
    }
}
