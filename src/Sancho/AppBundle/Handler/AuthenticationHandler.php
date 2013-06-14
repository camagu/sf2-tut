<?php

namespace Sancho\AppBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    private $router;
    private $route;
    private $routeParam;
    private $userParamMethod;

    public function __construct(RouterInterface $router, $route, $routeParam = 'id', $userParamMethod = 'getId')
    {
        $this->router = $router;
        $this->route = $route;
        $this->routeParam = $routeParam;
        $this->userParamMethod = $userParamMethod;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $path = $this->router->generate($this->route, array(
            $this->routeParam => $user->{$this->userParamMethod}()
        ));

        return new RedirectResponse($path);
    }
}
