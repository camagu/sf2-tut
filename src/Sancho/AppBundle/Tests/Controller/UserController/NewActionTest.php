<?php

namespace Sancho\AppBundle\Tests\Controller;

use Sancho\AppBundle\Tests\PageTestCase;

class NewActionTest extends PageTestCase
{
    private $title = 'Sign up';

    private $submit = 'Create my account';

    protected  function getHeading()
    {
        return $this->title;
    }

    protected function getPageTitle()
    {
        return $this->title;
    }

    protected function requestPage()
    {
        $path = $this->getUrl('sancho_app_user_new');
        return $this->fetchCrawler($path);
    }

    public function testSubmitFormWithInvalidData()
    {
        $oldCount = $this->getUserCount();

        try {
            $form = $this->crawler->selectButton($this->submit)->form();
            $this->crawler = $this->client->submit($form);
        } catch(\Exception $e) {
            $this->fail($e->getMessage());
        }

        $count = $this->getUserCount();
        $this->assertEquals($oldCount, $count, "Creates a user");

        $this->assertContains(
            'should not',
            $this->crawler->text(),
            "Doesn't show error messages"
        );
    }

    public function testSubmitFormWithValidData()
    {
        $namespace = 'sancho_app_user_registration';

        $oldCount = $this->getUserCount();

        try {
            $form = $this->crawler->selectButton($this->submit)->form();
            $this->crawler = $this->client->submit($form, array(
                "{$namespace}[name]"                  => 'Don Señor',
                "{$namespace}[email]"                 => 'don@senor.loc',
                "{$namespace}[plainPassword][first]"  => '12345678',
                "{$namespace}[plainPassword][second]" => '12345678'
            ));
        } catch(\Exception $e) {
            $this->fail($e->getMessage());
        }

        $count = $this->getUserCount();
        $this->assertNotEquals($oldCount, $count, "Doesn't create user");

        $this->crawler = $this->client->followRedirect();

        $expectedUrl = $this->getUrl('sancho_app_user_show', array(
            'id' => $this->getUserId()
        ));

        $this->assertEquals(
            $expectedUrl,
            $this->client->getRequest()->getRequestUri(),
            "Doesn't redirect"
        );

        $this->assertContains(
            'Welcome to the Sample App!',
            $this->crawler->text(),
            "Doesn't set flash message"
        );

        $this->hasLink('Sign out');
    }

    private function getUserCount()
    {
        $repository = $this->get('doctrine')
            ->getRepository('SanchoAppBundle:User');

        return (int) $repository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    private function getUserId()
    {
        $repository = $this->get('doctrine')
            ->getRepository('SanchoAppBundle:User');

        return $repository->findOneBy(array())->getId();
    }
}
