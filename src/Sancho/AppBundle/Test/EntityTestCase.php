<?php

namespace Sancho\AppBundle\Test;

abstract class EntityTestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->entity = $this->getEntity();

        if ($this->entityAlias) {
            $this->{$this->entityAlias} = $this->entity;
        }
    }

    abstract protected function getEntity();

    public function testEntity()
    {
        $this->isValid($this->entity);
    }

    abstract public function accessorProvider();

    /**
     * @dataProvider accessorProvider
     */
    public function testAccessors($attr, $value)
    {
        $setter = 'set'.ucfirst($attr);
        $getter = 'get'.ucfirst($attr);

        $this->assertTrue(method_exists($this->entity, $setter), "Object has $setter method");
        $this->assertTrue(method_exists($this->entity, $getter), "Object has $getter method");

        $this->assertEquals($this->entity, $this->entity->$setter($value));
        $this->assertEquals($value, $this->entity->$getter());
    }

    abstract public function getterProvider();

    /**
     * @dataProvider getterProvider
     */
    public function testGetters($attr)
    {
        $getter = 'get'.ucfirst($attr);
        $this->assertTrue(method_exists($this->entity, $getter), "Object has $getter method");
    }

    protected function isValid($entity, $success = true, $message = '', $groups = null)
    {
        $validator = $this->get('validator');
        $result = !count($validator->validate($entity, $groups));

        if ($success) {
            $this->assertTrue($result, "The entity is not valid. {$message}");
        } else {
            $this->assertFalse($result, "The entity is valid. {$message}");
        }
    }

    protected function isPropertyValid($entity, $property, $success = true, $message = '', $groups = null)
    {
        $validator = $this->get('validator');
        $result = !count($validator->validateProperty($entity, $property, $groups));

        if ($success) {
            $this->assertTrue($result, "The property is not valid. {$message}");
        } else {
            $this->assertFalse($result, "The property is valid. {$message}");
        }
    }

    protected function save($entity)
    {
        $em = $this->get('doctrine')->getManager();

        $em->persist($entity);
        $em->flush();
    }
}
