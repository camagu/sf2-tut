<?php

namespace Sancho\AppBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class EntityTestCase extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();

        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->validator = static::$kernel->getContainer()
            ->get('validator');

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->em->getConnection()->beginTransaction();

        $this->fixture = $this->getFixture();

        if ($this->fixtureAlias) {
            $this->{$this->fixtureAlias} = $this->fixture;
        }
    }

    public function tearDown()
    {
        $this->em->getConnection()->rollback();
        $this->em->close();
    }

    abstract protected function getFixture();

    public function testFixture()
    {
        $this->assertTrue($this->validate($this->fixture));
    }

    /**
     * @dataProvider accessorProvider
     */
    public function testAccessors($attr, $value)
    {
        $setter = 'set'.ucfirst($attr);
        $getter = 'get'.ucfirst($attr);

        $this->assertTrue(method_exists($this->fixture, $setter), "Object has $setter method");
        $this->assertTrue(method_exists($this->fixture, $getter), "Object has $getter method");

        $this->assertEquals($this->fixture, $this->fixture->$setter($value));
        $this->assertEquals($value, $this->fixture->$getter());
    }

    /**
     * @dataProvider getterProvider
     */
    public function testGetters($attr)
    {
        $getter = 'get'.ucfirst($attr);
        $this->assertTrue(method_exists($this->fixture, $getter), "Object has $getter method");
    }

    abstract public function getterProvider();

    abstract public function accessorProvider();

    protected function validate($entity)
    {
        return !count($this->validator->validate($entity));
    }

    protected function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
