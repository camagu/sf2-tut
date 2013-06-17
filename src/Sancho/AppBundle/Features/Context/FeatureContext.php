<?php

namespace Sancho\AppBundle\Features\Context;

use Sancho\TestBundle\Features\Context\BaseContext;

use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends BaseContext

{
    private $parameters;

    private $user;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct();
        $this->parameters = $parameters;
    }

    /**
     * @Given /^a user visits the sign in page$/
     */
    public function aUserVisitsTheSignInPage()
    {
        $router = $this->kernel->getContainer()->get('router');
        $login_path = $router->generate('sancho_app_session_new');

        $this->getSession()->visit($login_path);
    }

    /**
     * @When /^he submits invalid sign in information$/
     */
    public function heSubmitsInvalidSignInInformation()
    {
        $this->getSession()->getPage()->findButton('Sign in')->click();
    }

    /**
     * @Then /^he should see an error message$/
     */
    public function heShouldSeeAnErrorMessage()
    {
        assertNotNull($this->getSession()->getPage()->find('css', '.alert-error'));
    }

    /**
     * @Given /^the user has an account$/
     */
    public function theUserHasAnAccount()
    {
        $this->loadFixtures(array(
                'Sancho\AppBundle\Tests\Fixtures\LoadUserData',
        ));

        $this->user = $this->kernel
            ->getContainer()
            ->get('doctrine')
            ->getRepository('SanchoAppBundle:User')
            ->findOneBy(array());

        $this->user->setPlainPassword('password');
        $this->kernel
            ->getContainer()
            ->get('sancho_app.user_manager')
            ->updateUser($this->user);
    }

    /**
     * @When /^the user submits valid sign in information$/
     */
    public function theUserSubmitsValidSignInInformation()
    {
        $page = $this->getSession()->getPage();
        $page->findField('_username')->setValue($this->user->getEmail());
        $page->findField('_password')->setValue('password');

        $page->findButton('Sign in')->click();
    }

    /**
     * @Then /^he should see his profile page$/
     */
    public function heShouldSeeHisProfilePage()
    {
        $path = $this->kernel
            ->getContainer()
            ->get('router')
            ->generate(
                'sancho_app_user_show',
                array(
                    'id' => $this->user->getId()
                ),
                true
            );

        assertEquals(
            $path,
            $this->getSession()->getCurrentUrl()
        );
    }

    /**
     * @Given /^he should see a sign out link$/
     */
    public function heShouldSeeASignOutLink()
    {
        assertNotNull($this->getSession()->getPage()->findLink('Sign out'));
    }
}
