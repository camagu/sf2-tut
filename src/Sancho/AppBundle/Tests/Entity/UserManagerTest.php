<?php

namespace Sancho\AppBundle\Entity;

use Sancho\AppBundle\Entity\UserManager;
use Sancho\AppBundle\Entity\User;

class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $user;
    protected $userManager;

    public function setUp()
    {
        $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->encoderFactory = $this->getMock('Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface');

        $this->userManager = new UserManager($this->objectManager, $this->encoderFactory);

        $this->user = new User();
    }

    protected function saveUserTest($method)
    {
        $this->objectManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($this->user));

        $this->objectManager
            ->expects($this->once())
            ->method('flush');

        $encoder = $this->getMock('Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface');

        $this->encoderFactory
            ->expects($this->once())
            ->method('getEncoder')
            ->will($this->returnValue($encoder));

        $encoder
            ->expects($this->once())
            ->method('encodePassword')
            ->with('password', $this->user->getSalt())
            ->will($this->returnValue('encodedPassword'));

        $this->user->setPlainPassword('password');
        $this->userManager->{$method}($this->user);

        $this->assertEquals(
            'encodedPassword',
            $this->user->getPassword()
        );

    }

    public function testCreateUser()
    {
        $this->saveUserTest('createUser');
    }

    public function testUpdateUser()
    {
        $this->saveUserTest('updateUser');
    }
}
