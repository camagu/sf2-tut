<?php

namespace Sancho\AppBundle\Test;

class ClientTestCase extends TransactionTestCase
{
    protected function request()
    {
        $args = func_get_args();
        if (isset($args[1]) && !preg_match('/^\\//', $args[1])) {
            $args[1] = $this->generatePath($args[1]);
        }

        return call_user_func_array(array($this->getClient(), 'request'), $args);
    }

    protected function generatePath($route, $context = array())
    {
        return $this->get('router')->generate($route, $context);
    }

    /**
     * @todo Create custom assert
     */
    protected function linkTest($link, $route)
    {
        $link = $this->requestPage()->selectLink($link)->link();
        $this->getClient()->click($link);

        $this->assertEquals(
            $this->generatePath($route),
            $this->getClient()->getRequest()->getRequestUri()
        );
    }
}
