<?php

namespace Sancho\AppBundle\Tests\Entity;

use Sancho\AppBundle\Entity\User;
use Sancho\AppBundle\Test\EntityTestCase;
use Sancho\AppBundle\Tests\Fixtures\UserFixture;

class UserTest extends EntityTestCase
{
    protected $fixtureAlias = 'user';

    public function getFixture()
    {
        return UserFixture::single();
    }

    public function testImplementsUserInterface()
    {
        $this->assertInstanceOf(
            'Symfony\\Component\\Security\\Core\\User\\UserInterface',
            $this->user
        );
    }

    /**
     * @dataProvider nameValueProvider
     */
    public function testNameValidations($value, $valid, $message)
    {
        $this->user->setName($value);
        $this->assertEquals($valid, $this->validate($this->user), $message);
    }

    public function nameValueProvider()
    {
        return array(
            array('', false, "Name can't accept empty values"),
            array(str_repeat('a', 51), false, "Name can't accept values longer than 50")
        );
    }

    /**
     * @dataProvider emailValueProvider
     */
    public function testEmailValidations($value, $valid, $message)
    {
        $this->user->setEmail($value);
        $this->assertEquals($valid, $this->validate($this->user), $message);
    }

    public function emailValueProvider()
    {
        $data = array(
            array('', false, "Email can't accept empty values"),
        );

        $validEmails = array(
            'user@foo.COM',
            'A_US-ER@f.b.org',
            'frst.lst@foo.jp',
            'a+b@baz.cn',
        );

        foreach ($validEmails as $email) {
            $data[] = array($email, true, "Email should accept {$email}");
        }

        $invalidEmails = array(
            'user@foo,com',
            'user_at_foo.org',
            'example.user@foo.',
            'foo@bar_baz.com',
            'foo@bar+baz.com',
        );

        foreach ($invalidEmails as $email) {
            $data[] = array($email, false, "Email shouldn't accept {$email}");
        }

        return $data;
    }

    public function testEmailUniqueness()
    {
        $userWithSameEmail = clone $this->user;
        $this->save($userWithSameEmail);

        $this->assertFalse($this->validate($this->user));
    }

    public function testEmailIsDowncased()
    {
        $mixedCasedEmail = 'MiXEDcAsED01@EmaiL.LoC';
        $this->user->setEmail($mixedCasedEmail);

        $this->save($this->user);

        $this->assertEquals(
            strtolower($mixedCasedEmail),
            $this->user->getEmail()
        );
    }

    /**
     * @dataProvider plainPasswordValueProvider
     */
    public function testPlainPasswordValidations($value, $valid, $message)
    {
        $this->user->setPlainPassword($value);
        $this->assertEquals($valid, $this->validate($this->user), $message);
    }

    public function plainPasswordValueProvider()
    {
        return array(
            array(str_repeat('a', 5), false, "Plain password can't be shorter than 6"),
        );
    }

    public function testGetUsernameReturnsEmail()
    {
        $this->assertEquals(
            $this->user->getEmail(),
            $this->user->getUsername()
        );
    }

    public function testGetSaltReturnsEmptyString()
    {
        $this->assertInternalType('string', $this->user->getSalt());
        $this->assertEmpty($this->user->getSalt());
    }

    public function testGetRolesReturnsDefaultRole()
    {
        $this->assertEquals(
            array('ROLE_USER'),
            $this->user->getRoles()
        );
    }

    public function accessorProvider()
    {
        return array(
            array('name', 'Another Example User'),
            array('email', 'another_user@example.loc'),
            array('password', '12345678'),
            array('plainPassword', '0987654321'),
        );
    }

    public function getterProvider()
    {
        return array(
            array('id'),
            array('created'),
            array('updated'),
        );
    }
}
