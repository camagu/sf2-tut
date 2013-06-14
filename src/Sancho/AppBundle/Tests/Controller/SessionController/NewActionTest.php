<?php

namespace Sancho\AppBundle\Tests\SessionController;

use Sancho\AppBundle\Tests\PageTestCase;

class NewActionTest extends PageTestCase
{
    private $title = 'Sign in';
    private $submit = 'Sign in';
    protected $fixtures = array(
        'Sancho\AppBundle\Tests\Fixtures\LoadUserData'
    );

    protected function init()
    {
        $this->user = $this->get('doctrine')
            ->getRepository('SanchoAppBundle:User')
            ->findOneBy(array());

        $this->user->setPlainPassword('password');
        $this->get('sancho_app.user_manager')->updateUser($this->user);
    }

    protected function getHeading()
    {
        return $this->title;
    }

    protected function getPageTitle()
    {
        return $this->title;
    }

    protected function requestPage()
    {
        $path = $this->getUrl('sancho_app_session_new');
        return $this->fetchCrawler($path);
    }

    public function testRegisterLink()
    {
        $this->doesLinkPointsTo('Sign up now!', $this->getUrl(
            'sancho_app_user_new'
        ));
    }

    public function testSubmitFormWithInvalidData()
    {
        $form = $this->crawler->selectButton($this->submit)->form();
        $this->crawler = $this->client->submit($form);

        $this->crawler = $this->client->followRedirect();

        $this->assertcontains(
            'credentials',
            $this->crawler->text()
        );
    }

    public function testSubmitForWithValidData()
    {
        $form = $this->crawler->selectButton($this->submit)->form();
        $this->crawler = $this->client->submit($form, array(
            '_username' => $this->user->getEmail(),
            '_password' => $this->user->getPlainPassword(),
        ));

        $this->crawler = $this->client->followRedirect();

        $this->assertEquals(
            $this->getUrl('sancho_app_user_show', array('id' => $this->user->getId())),
            $this->client->getRequest()->getRequestUri()
        );

        $this->hasLink('Sign in', false);
        $this->doesLinkPointsTo('Profile', $this->getUrl('sancho_app_user_show', array(
            'id' => $this->user->getId(),
        )));
        $this->doesLinkPointsTo('Sign out', $this->getUrl('sancho_app_session_delete'));
    }
}
