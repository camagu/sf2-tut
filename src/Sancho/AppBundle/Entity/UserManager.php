<?php

namespace Sancho\AppBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManager
{
    private $objectManager;
    private $encoderFactory;

    public function __construct(ObjectManager $objectManager, EncoderFactoryInterface $encoderfactory)
    {
        $this->setObjectManager($objectManager);
        $this->setEncoderFactory($encoderfactory);
    }

    public function createUser($user)
    {
        $this->saveUser($user);
    }

    public function updateUser($user)
    {
        $this->saveUser($user);
    }

    protected function saveUser($user)
    {
        $om = $this->getObjectManager();

        $this->updatePassword($user);

        $om->persist($user);
        $om->flush();
    }

    protected function updatePassword($user)
    {
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $ef = $this->getEncoderFactory();

            $encoder = $ef->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
        }
    }

    protected function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    protected function getObjectManager()
    {
        return $this->objectManager;
    }

    protected function setEncoderFactory(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    protected function getEncoderFactory()
    {
        return $this->encoderFactory;
    }
}
