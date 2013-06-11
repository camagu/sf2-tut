<?php

namespace Sancho\AppBundle\Tests\Twig;

use Sancho\AppBundle\Twig\SanchoAppExtension;

class SanchoAppExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $baseTitle = 'Symfony2 Tutorial Sample App';

    /**
     * @dataProvider titleProvider
     */
    public function testFullTitleFunction($template, $expected)
    {
        $twig = new \Twig_Environment(new \Twig_Loader_String(), array('cache' => false));
        $twig->addExtension(new SanchoAppExtension());

        $template = $twig->loadTemplate($template);

        $actual = $template->render(array());
        $this->assertEquals($expected, $actual);
    }

    public function titleProvider()
    {
        return array(
            array("{{ full_title() }}", $this->baseTitle),
            array("{{ full_title('helo') }}", "{$this->baseTitle} | helo"),
            array("{{ full_title('foo bar') }}", "{$this->baseTitle} | foo bar"),
        );
    }
}
