<?php

namespace Sancho\AppBundle\Test;

abstract class EntityTestCase extends TransactionTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->validator = $this->get('validator');

        $this->fixture = $this->getFixture();

        if ($this->fixtureAlias) {
            $this->{$this->fixtureAlias} = $this->fixture;
        }
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

    /**
     * @todo Create custom constraint
     */
    protected function validate($entity)
    {
        return !count($this->validator->validate($entity));
    }

    protected function save($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
