<?php

namespace Sancho\AppBundle\Twig;

class SanchoAppExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('full_title', function($title = '') {
                return 'Symfony2 Tutorial Sample App' .
                       ($title ? " | {$title}" : '');
            }),
            new \Twig_SimpleFunction('gravatar_for', function($email) {
                $gravatarId = md5(strtolower(trim($email)));
                return "https://www.gravatar.com/avatar/{$gravatarId}";
            }),
        );
    }

    public function getName()
    {
        return 'sancho_app_extension';
    }
}
